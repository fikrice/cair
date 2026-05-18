<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        // Filter Produk
        if ($request->filled('product_search')) {
            $search = $request->product_search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter Referensi
        if ($request->filled('ref_search')) {
            $query->where('reference', 'like', "%{$request->ref_search}%");
        }

        // Filter Tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        
        $allowedSortColumns = ['created_at', 'quantity', 'type'];
        if (in_array($sort, $allowedSortColumns)) {
            $query->orderBy($sort, $order);
        } else {
            $query->latest();
        }

        $movements = $query->paginate(15)->withQueryString();

        return view('pages.stock_movements.index', compact('movements'));
    }
}
