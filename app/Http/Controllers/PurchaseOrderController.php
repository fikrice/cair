<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'creator']);

        // Search by PO Number or Supplier Name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        $allowedFields = ['po_date', 'po_number', 'supplier_id', 'total_amount', 'status', 'created_at'];
        if (in_array($sortField, $allowedFields)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $purchaseOrders = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => PurchaseOrder::count(),
            'pending' => PurchaseOrder::where('status', 'pending')->count(),
            'received' => PurchaseOrder::where('status', 'received')->count(),
            'draft' => PurchaseOrder::where('status', 'draft')->count(),
            'cancelled' => PurchaseOrder::where('status', 'cancelled')->count(),
        ];

        return view('pages.purchase_orders.index', compact('purchaseOrders', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $poNumber = PurchaseOrder::generatePONumber();
        $suppliers = Supplier::active()->get();
        $products = Product::orderBy('name')->get();
        
        return view('pages.purchase_orders.create', compact('poNumber', 'suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'po_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:po_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,pending',
        ]);

        try {
            DB::beginTransaction();

            $po = PurchaseOrder::create([
                'po_number' => PurchaseOrder::generatePONumber(),
                'supplier_id' => $request->supplier_id,
                'po_date' => $request->po_date,
                'expected_delivery_date' => $request->expected_delivery_date,
                'notes' => $request->notes,
                'status' => $request->status,
                'total_amount' => 0, // Will update after items
            ]);

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                $po->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);
                $totalAmount += $subtotal;
            }

            $po->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('purchase-orders.index')->with('success', 'Purchase Order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal membuat PO: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'creator', 'items.product']);
        return view('pages.purchase_orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('warning', 'Hanya PO status Draft yang dapat diedit.');
        }

        $suppliers = Supplier::active()->get();
        $products = Product::orderBy('name')->get();
        $purchaseOrder->load('items');

        return view('pages.purchase_orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'PO yang sudah diproses tidak dapat diubah.');
        }

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'po_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:po_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,pending',
        ]);

        try {
            DB::beginTransaction();

            $purchaseOrder->update([
                'supplier_id' => $request->supplier_id,
                'po_date' => $request->po_date,
                'expected_delivery_date' => $request->expected_delivery_date,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);

            // Clear old items and recreate
            $purchaseOrder->items()->delete();

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];
                $purchaseOrder->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);
                $totalAmount += $subtotal;
            }

            $purchaseOrder->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('purchase-orders.index')->with('success', 'Purchase Order berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui PO: ' . $e->getMessage());
        }
    }

    public function receive(PurchaseOrder $purchaseOrder)
    {
        if (trim(strtolower($purchaseOrder->status)) !== 'pending') {
            return back()->with('error', 'Hanya PO berstatus Pending yang dapat diterima.');
        }

        if ($purchaseOrder->payment_status !== 'paid') {
            return back()->with('error', 'Barang belum dapat diterima karena tagihan belum dilunasi oleh Finance.');
        }
    
        try {
            DB::beginTransaction();
    
            foreach ($purchaseOrder->items as $item) {
                $product = $item->product;
                $product->increment('stock', $item->quantity);
    
                // Log Stock Movement (Best Practice)
                \App\Models\StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'in',
                    'quantity' => $item->quantity,
                    'reference' => $purchaseOrder->po_number,
                    'reason' => 'Penerimaan Barang dari PO',
                ]);
            }
    
            $purchaseOrder->update([
                'status' => 'received',
                'received_at' => now()
            ]);

            $purchaseOrder->update([
                'status' => 'received',
                'received_at' => now()
            ]);
    
            DB::commit();
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'PO diterima, stok diperbarui, dan histori pengeluaran telah dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menerima PO: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Hanya PO status Draft yang dapat dihapus.');
        }

        $purchaseOrder->delete();
        return redirect()->route('purchase-orders.index')->with('success', 'PO berhasil dihapus.');
    }

    public function cancel(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'PO yang sudah diterima tidak dapat dibatalkan.');
        }

        $purchaseOrder->update(['status' => 'cancelled']);
        return redirect()->route('purchase-orders.show', $purchaseOrder)->with('success', 'Purchase Order berhasil dibatalkan.');
    }

    public function print(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'creator', 'items.product']);
        return view('pages.purchase_orders.print', compact('purchaseOrder'));
    }

    public function payment(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Tagihan tidak dapat diproses karena status pesanan tidak sesuai.');
        }

        if ($purchaseOrder->payment_status === 'paid') {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Tagihan ini sudah lunas.');
        }

        $purchaseOrder->load('supplier', 'items.product', 'transactions');
        
        $totalPaid = $purchaseOrder->transactions->sum('amount');
        $remainingAmount = max(0, $purchaseOrder->total_amount - $totalPaid);

        return view('pages.purchase_orders.payment', compact('purchaseOrder', 'totalPaid', 'remainingAmount'));
    }
}
