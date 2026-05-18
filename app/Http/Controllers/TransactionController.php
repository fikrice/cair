<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['salesOrder', 'creator']);

        // Filter by Search (SO Number)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('salesOrder', function ($q) use ($search) {
                $q->where('so_number', 'like', "%{$search}%");
            });
        }

        // Filter by Payment Method
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        // Filter by Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }

        // Sorting
        $sort = $request->get('sort', 'payment_date');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $transactions = $query->paginate(10)->withQueryString();

        // Stats for cards
        $stats = [
            'total_income' => Transaction::where('type', 'income')->sum('amount'),
            'total_expense' => Transaction::where('type', 'expense')->sum('amount'),
            'this_month_income' => Transaction::where('type', 'income')->whereMonth('payment_date', date('m'))->whereYear('payment_date', date('Y'))->sum('amount'),
            'this_month_expense' => Transaction::where('type', 'expense')->whereMonth('payment_date', date('m'))->whereYear('payment_date', date('Y'))->sum('amount'),
            'cash_count' => Transaction::where('payment_method', 'cash')->count(),
            'transfer_count' => Transaction::where('payment_method', 'transfer')->count(),
        ];

        return view('pages.transactions.index', compact('transactions', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $salesOrderId = $request->get('sales_order_id');
        $salesOrder = null;

        if ($salesOrderId) {
            $salesOrder = SalesOrder::findOrFail($salesOrderId);
            
            // Check if already paid
            if ($salesOrder->payment_status === 'paid') {
                return redirect()->route('sales-orders.show', $salesOrder)
                    ->with('error', 'Pesanan ini sudah lunas.');
            }
        }

        // List pending sales orders for selection
        $pendingSalesOrders = SalesOrder::where('payment_status', '!=', 'paid')
            ->where('status', 'processing')
            ->orderBy('so_number', 'desc')
            ->get();

        // List pending purchase orders for selection
        $pendingPurchaseOrders = \App\Models\PurchaseOrder::where('payment_status', '!=', 'paid')
            ->where('status', 'pending')
            ->orderBy('po_number', 'desc')
            ->get();

        return view('pages.transactions.create', compact('salesOrder', 'pendingSalesOrders', 'pendingPurchaseOrders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'purchase_order_id' => 'nullable|exists:purchase_orders,id',
            'reference_number' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,transfer,e-wallet',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            // Create Transaction
            $transaction = Transaction::create([
                'type' => $request->type,
                'sales_order_id' => $request->sales_order_id,
                'purchase_order_id' => $request->purchase_order_id,
                'reference_number' => $request->reference_number,
                'description' => $request->description,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'note' => $request->note,
                'created_by' => auth()->id(),
            ]);

            // If it's linked to an SO, update SO Payment Status
            if ($request->sales_order_id) {
                $salesOrder = SalesOrder::findOrFail($request->sales_order_id);
                $totalPaid = $salesOrder->transactions()->sum('amount');
                
                if ($totalPaid >= $salesOrder->total_amount) {
                    $salesOrder->update([
                        'payment_status' => 'paid',
                        // Note: SO remains 'processing' until Warehouse completes the shipment.
                    ]);
                } else {
                    $salesOrder->update(['payment_status' => 'partial']);
                }
            }

            // If it's linked to a PO, update PO Payment Status
            if ($request->purchase_order_id) {
                $purchaseOrder = \App\Models\PurchaseOrder::findOrFail($request->purchase_order_id);
                $totalPaid = $purchaseOrder->transactions()->sum('amount');
                
                if ($totalPaid >= $purchaseOrder->total_amount) {
                    $purchaseOrder->update([
                        'payment_status' => 'paid',
                        // Note: PO remains 'pending' until Warehouse receives the goods.
                    ]);
                } else {
                    $purchaseOrder->update(['payment_status' => 'partial']);
                }
            }

            return redirect()->route('transactions.index')
                ->with('success', "Transaksi berhasil dicatat.");
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['salesOrder', 'creator']);
        return view('pages.transactions.show', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        return DB::transaction(function () use ($transaction) {
            $salesOrder = $transaction->salesOrder;
            // Re-calculate payment status for PO
            if ($transaction->purchase_order_id) {
                $purchaseOrder = $transaction->purchaseOrder;
                $totalPaidPO = $purchaseOrder->transactions()->where('id', '!=', $transaction->id)->sum('amount');
                if ($totalPaidPO <= 0) {
                    $purchaseOrder->update(['payment_status' => 'unpaid']);
                } elseif ($totalPaidPO < $purchaseOrder->total_amount) {
                    $purchaseOrder->update(['payment_status' => 'partial']);
                } else {
                    $purchaseOrder->update(['payment_status' => 'paid']);
                }
            }

            $transaction->delete();

            // Re-calculate payment status for SO
            if ($salesOrder) {
                $totalPaid = $salesOrder->transactions()->sum('amount');
                if ($totalPaid <= 0) {
                    $salesOrder->update(['payment_status' => 'unpaid']);
                } elseif ($totalPaid < $salesOrder->total_amount) {
                    $salesOrder->update(['payment_status' => 'partial']);
                } else {
                    $salesOrder->update(['payment_status' => 'paid']);
                }
            }

            return redirect()->route('transactions.index')
                ->with('success', 'Catatan transaksi berhasil dihapus.');
        });
    }
}
