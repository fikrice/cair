<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SalesOrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [];
    }
    public function index(Request $request)
    {
        $query = SalesOrder::with(['creator', 'items', 'stockMovements']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('so_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $allowedFields = ['so_date', 'so_number', 'customer_name', 'total_amount', 'status', 'created_at'];
        
        if (in_array($sortField, $allowedFields)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $salesOrders = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => SalesOrder::count(),
            'completed' => SalesOrder::where('status', 'completed')->count(),
            'processing' => SalesOrder::where('status', 'processing')->count(),
            'draft' => SalesOrder::where('status', 'draft')->count(),
            'cancelled' => SalesOrder::where('status', 'cancelled')->count(),
        ];

        return view('pages.sales_orders.index', compact('salesOrders', 'stats'));
    }

    public function create()
    {
        $soNumber = SalesOrder::generateSoNumber();
        $products = Product::where('stock', '>', 0)->get();
        return view('pages.sales_orders.create', compact('soNumber', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'so_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Validate stock availability first
            foreach ($request->items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                if ($product->stock < $itemData['quantity']) {
                    return back()->with('error', "Stok produk {$product->name} tidak mencukupi (Tersedia: {$product->stock}).");
                }
            }

            $salesOrder = SalesOrder::create([
                'so_number' => SalesOrder::generateSoNumber(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'so_date' => $request->so_date,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'status' => $request->status ?? 'draft',
                'created_by' => auth()->id(),
            ]);

            $totalAmount = 0;
            foreach ($request->items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $subtotal = $product->selling_price * $itemData['quantity'];
                
                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $product->selling_price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $salesOrder->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('sales-orders.index')->with('success', 'Sales Order berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat Sales Order: ' . $e->getMessage());
        }
    }

    public function edit(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'draft') {
            return back()->with('error', 'Hanya pesanan berstatus Draft yang dapat diubah.');
        }

        $salesOrder->load('items.product');
        $products = Product::all();
        
        // Transform items for Alpine.js
        $existingItems = $salesOrder->items->map(function($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'stock' => $item->product->stock + $item->quantity // Available if this item is cancelled
            ];
        });

        return view('pages.sales_orders.edit', compact('salesOrder', 'products', 'existingItems'));
    }

    public function update(Request $request, SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'draft') {
            return back()->with('error', 'Hanya pesanan berstatus Draft yang dapat diubah.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'so_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Validate stock availability (considering current SO items)
            foreach ($request->items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $oldItem = $salesOrder->items()->where('product_id', $product->id)->first();
                $oldQty = $oldItem ? $oldItem->quantity : 0;
                
                if ($product->stock + $oldQty < $itemData['quantity']) {
                    return back()->with('error', "Stok produk {$product->name} tidak mencukupi.");
                }
            }

            $salesOrder->update([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'so_date' => $request->so_date,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'status' => $request->status ?? $salesOrder->status,
            ]);

            // Delete old items and create new ones
            $salesOrder->items()->delete();

            $totalAmount = 0;
            foreach ($request->items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $subtotal = $product->selling_price * $itemData['quantity'];
                
                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $product->selling_price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $salesOrder->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('sales-orders.show', $salesOrder)->with('success', 'Sales Order berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui Sales Order: ' . $e->getMessage());
        }
    }

    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load(['creator', 'items.product']);
        return view('pages.sales_orders.show', compact('salesOrder'));
    }

    public function complete(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'processing') {
            return back()->with('error', 'Hanya pesanan yang sedang diproses yang dapat dikonfirmasi stoknya.');
        }

        if ($salesOrder->payment_status !== 'paid') {
            return back()->with('error', 'Pesanan belum dapat dikonfirmasi karena belum dibayar lunas oleh Finance.');
        }

        // Check if stock already deducted for this SO
        $alreadyDeducted = \App\Models\StockMovement::where('reference', $salesOrder->so_number)->exists();
        if ($alreadyDeducted) {
            return back()->with('error', 'Stok untuk pesanan ini sudah pernah dikonfirmasi sebelumnya.');
        }
    
        try {
            DB::beginTransaction();
    
            // Double check stock before confirming
            foreach ($salesOrder->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Stok {$item->product->name} tidak cukup untuk disiapkan.");
                }
            }
    
            // Deduct stock and Log Movement
            foreach ($salesOrder->items as $item) {
                $product = $item->product;
                $product->decrement('stock', $item->quantity);
    
                // Log Stock Movement
                \App\Models\StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'reference' => $salesOrder->so_number,
                    'reason' => 'Penjualan SO (Stok Disiapkan)',
                ]);
            }
    
            // Mark SO status as completed since it's already paid and now shipped
            $salesOrder->update(['status' => 'completed']);
    
            DB::commit();
            return redirect()->route('sales-orders.show', $salesOrder)
                ->with('success', 'Stok telah dikonfirmasi dan pesanan berhasil diselesaikan (Completed).');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(SalesOrder $salesOrder)
    {
        if ($salesOrder->status === 'completed') {
            return back()->with('error', 'Pesanan yang sudah selesai tidak dapat dihapus.');
        }

        $salesOrder->delete();
        return redirect()->route('sales-orders.index')->with('success', 'Sales Order berhasil dihapus.');
    }

    public function cancel(SalesOrder $salesOrder)
    {
        if ($salesOrder->status === 'completed') {
            return back()->with('error', 'Pesanan yang sudah selesai tidak dapat dibatalkan.');
        }

        $salesOrder->update(['status' => 'cancelled']);
        return redirect()->route('sales-orders.show', $salesOrder)->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function print(SalesOrder $salesOrder)
    {
        $salesOrder->load(['items.product', 'creator']);
        return view('pages.sales_orders.print', compact('salesOrder'));
    }

    public function shippingLabel(SalesOrder $salesOrder)
    {
        $salesOrder->load(['items.product']);
        return view('pages.sales_orders.shipping_label', compact('salesOrder'));
    }

    public function payment(SalesOrder $salesOrder)
    {
        if (!in_array(auth()->user()->role, ['admin', 'finance'])) {
            abort(403);
        }

        if ($salesOrder->payment_status === 'paid') {
            return redirect()->route('sales-orders.show', $salesOrder)->with('error', 'Pesanan ini sudah lunas.');
        }

        $salesOrder->load('transactions');
        $totalPaid = $salesOrder->transactions->sum('amount');
        $remainingAmount = $salesOrder->total_amount - $totalPaid;

        return view('pages.sales_orders.payment', compact('salesOrder', 'remainingAmount'));
    }
}
