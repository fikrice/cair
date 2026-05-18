<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Laporan Penjualan (Sales Report)
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->toDateString());

        $query = SalesOrder::with(['creator', 'items.product'])
            ->where('status', 'completed')
            ->whereBetween('so_date', [$startDate, $endDate]);

        $salesOrders = $query->latest('so_date')->get();
        
        $summary = [
            'total_orders' => $salesOrders->count(),
            'total_revenue' => $salesOrders->sum('total_amount'),
            'total_paid' => Transaction::whereIn('sales_order_id', $salesOrders->pluck('id'))->sum('amount'),
        ];

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pages.reports.pdf.sales', compact('salesOrders', 'startDate', 'endDate', 'summary'));
            return $pdf->download("laporan-penjualan-{$startDate}-to-{$endDate}.pdf");
        }

        return view('pages.reports.sales', compact('salesOrders', 'startDate', 'endDate', 'summary'));
    }

    /**
     * Laporan Pembelian (Purchase Report)
     */
    public function purchases(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->toDateString());

        $query = PurchaseOrder::with(['supplier', 'creator'])
            ->where('status', 'received')
            ->whereBetween('po_date', [$startDate, $endDate]);

        $purchaseOrders = $query->latest('po_date')->get();

        $summary = [
            'total_orders' => $purchaseOrders->count(),
            'total_expense' => $purchaseOrders->sum('total_amount'),
        ];

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pages.reports.pdf.purchases', compact('purchaseOrders', 'startDate', 'endDate', 'summary'));
            return $pdf->download("laporan-pembelian-{$startDate}-to-{$endDate}.pdf");
        }

        return view('pages.reports.purchases', compact('purchaseOrders', 'startDate', 'endDate', 'summary'));
    }

    /**
     * Laporan Inventaris/Stok (Inventory Report)
     */
    public function inventory()
    {
        $products = Product::with('category')
            ->orderBy('stock', 'asc')
            ->get();

        $summary = [
            'total_products' => $products->count(),
            'total_stock' => $products->sum('stock'),
            'low_stock_items' => $products->where('stock', '<=', 'min_stock')->count(),
            'total_asset_value' => $products->sum(fn($p) => $p->stock * $p->purchase_price),
        ];

        if (request('export') === 'pdf') {
            $pdf = Pdf::loadView('pages.reports.pdf.inventory', compact('products', 'summary'));
            return $pdf->download("laporan-inventaris-" . now()->format('Y-m-d') . ".pdf");
        }

        return view('pages.reports.inventory', compact('products', 'summary'));
    }
}
