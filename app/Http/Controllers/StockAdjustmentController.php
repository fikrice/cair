<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StockAdjustmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (auth()->check() && auth()->user()->role === 'admin') {
                    abort(403, 'Aksi ini tidak diizinkan untuk Admin.');
                }
                return $next($request);
            }),
        ];
    }

    public function index(Request $request)
    {
        $query = StockAdjustment::with(['product', 'creator']);

        // Filter No. Ref
        if ($request->filled('ref_search')) {
            $query->where('adjustment_number', 'like', "%{$request->ref_search}%");
        }

        // Filter Produk
        if ($request->filled('product_search')) {
            $search = $request->product_search;
            $query->whereHas('product', function($pq) use ($search) {
                $pq->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter Tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sorting
        $sort = $request->get('sort', 'adjustment_date');
        $order = $request->get('order', 'desc');
        
        $allowedSortColumns = ['adjustment_number', 'adjustment_date', 'quantity', 'type'];
        if (in_array($sort, $allowedSortColumns)) {
            $query->orderBy($sort, $order);
        } else {
            $query->latest('adjustment_date');
        }

        $adjustments = $query->paginate(10)->withQueryString();

        return view('pages.stock_adjustments.index', compact('adjustments'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $reasons = [
            'damaged' => 'Barang Rusak',
            'lost' => 'Barang Hilang',
            'correction' => 'Koreksi Stok',
            'return' => 'Retur Barang',
            'other' => 'Lainnya',
        ];

        return view('pages.stock_adjustments.create', compact('products', 'reasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:addition,subtraction',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string',
            'notes' => 'nullable|string',
            'adjustment_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // Generate adjustment number
            $date = date('Ymd');
            $count = StockAdjustment::whereDate('created_at', date('Y-m-d'))->count() + 1;
            $adjustmentNumber = 'ADJ-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $adjustment = StockAdjustment::create([
                'adjustment_number' => $adjustmentNumber,
                'product_id' => $request->product_id,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'reason' => $request->reason,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
                'adjustment_date' => $request->adjustment_date,
            ]);

            // Update product stock
            $product = Product::find($request->product_id);
            
            // Validasi stok cukup jika tipe pengurangan
            if ($request->type === 'subtraction' && $product->stock < $request->quantity) {
                DB::rollBack();
                return back()->with('error', "Gagal! Stok produk '{$product->name}' tidak mencukupi. Stok saat ini: {$product->stock}")->withInput();
            }

            $signedQuantity = $request->type === 'addition' ? $request->quantity : -$request->quantity;
            
            if ($request->type === 'addition') {
                $product->increment('stock', $request->quantity);
            } else {
                $product->decrement('stock', $request->quantity);
            }

            // Record in stock_movements
            DB::table('stock_movements')->insert([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => 'adjustment',
                'quantity' => $signedQuantity,
                'reference' => $adjustmentNumber,
                'reason' => $request->reason . ': ' . ($request->notes ?: '-'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('stock-adjustments.index')
                ->with('success', "Penyesuaian stok {$adjustmentNumber} berhasil disimpan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(StockAdjustment $stockAdjustment)
    {
        $stockAdjustment->load(['product', 'creator']);
        return view('pages.stock_adjustments.show', compact('stockAdjustment'));
    }
}
