<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        
        // Basic Stats
        $stats = [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalStock' => Product::sum('stock'),
            'lowStockCount' => Product::whereColumn('stock', '<=', 'min_stock')->count(),
            'totalSales' => SalesOrder::where('status', 'completed')->sum('total_amount'),
            'totalPurchase' => PurchaseOrder::where('status', 'received')->sum('total_amount'),
            'pendingSO' => SalesOrder::where('status', 'processing')->count(),
            'pendingPO' => PurchaseOrder::where('status', 'pending')->count(),
        ];

        // Data for Revenue Chart (Last 6 Months)
        $chartData = ['labels' => [], 'values' => []];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = SalesOrder::where('status', 'completed')
                ->whereMonth('so_date', $month->month)
                ->whereYear('so_date', $month->year)
                ->sum('total_amount');
            
            $chartData['labels'][] = $month->format('M Y');
            $chartData['values'][] = (int) $revenue;
        }

        // Data for Pie Chart (Stock Distribution by Category)
        $pieChartData = Category::withSum('products', 'stock')
            ->get()
            ->map(fn($cat) => [
                'label' => $cat->name,
                'value' => (int) ($cat->products_sum_stock ?? 0)
            ])
            ->filter(fn($item) => $item['value'] > 0)
            ->values()
            ->toArray();

        // Recent Data
        $recentSales = SalesOrder::with('creator')->latest()->take(5)->get();
        $recentPurchases = PurchaseOrder::with(['supplier', 'creator'])->latest()->take(5)->get();
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        // Warehouse Specific Data
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->take(5)->get();
        $pendingShipments = SalesOrder::where('status', 'processing')
            ->where('payment_status', 'paid')
            ->whereDoesntHave('stockMovements')
            ->latest()->take(5)->get();
        $incomingGoods = PurchaseOrder::where('status', 'pending')
            ->where('payment_status', 'paid')
            ->latest()->take(5)->get();

        // Weekly Movement Data (Inbound vs Outbound)
        $movementChart = ['labels' => [], 'inbound' => [], 'outbound' => []];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayLabel = now()->subDays($i)->format('d M');
            
            $in = \App\Models\StockMovement::where('type', 'in')->whereDate('created_at', $date)->sum('quantity');
            $out = \App\Models\StockMovement::where('type', 'out')->whereDate('created_at', $date)->sum('quantity');
            
            $movementChart['labels'][] = $dayLabel;
            $movementChart['inbound'][] = (int) $in;
            $movementChart['outbound'][] = (int) $out;
        }

        // Finance Specific Data
        $pendingPayments = SalesOrder::where('status', 'processing')
            ->where('payment_status', '!=', 'paid')
            ->latest()->take(5)->get();

        $pendingPurchases = PurchaseOrder::where('status', 'pending')
            ->where('payment_status', '!=', 'paid')
            ->latest()->take(5)->get();
            
        $totalReceivables = SalesOrder::where('status', 'processing')
            ->where('payment_status', '!=', 'paid')
            ->sum('total_amount');
        $totalPayables = PurchaseOrder::where('status', 'pending')
            ->where('payment_status', '!=', 'paid')
            ->sum('total_amount'); // POs received but maybe not fully tracked in specific payment table yet

        // Data for Revenue vs Expense Chart (Last 6 Months)
        $financeChart = ['labels' => [], 'revenue' => [], 'expense' => []];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $rev = SalesOrder::where('status', 'completed')
                ->whereMonth('so_date', $month->month)
                ->whereYear('so_date', $month->year)
                ->sum('total_amount');
            $exp = PurchaseOrder::where('status', 'received')
                ->whereMonth('po_date', $month->month)
                ->whereYear('po_date', $month->year)
                ->sum('total_amount');
            
            $financeChart['labels'][] = $month->format('M Y');
            $financeChart['revenue'][] = (int) $rev;
            $financeChart['expense'][] = (int) $exp;
        }

        // Purchasing Specific Data
        $vendorPerformance = \App\Models\Supplier::withCount(['purchaseOrders' => function($q) {
            $q->where('status', 'received');
        }])
        ->orderBy('purchase_orders_count', 'desc')
        ->take(5)
        ->get();

        $purchaseTrend = ['labels' => [], 'values' => []];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $amount = PurchaseOrder::where('status', 'received')
                ->whereMonth('po_date', $month->month)
                ->whereYear('po_date', $month->year)
                ->sum('total_amount');
            
            $purchaseTrend['labels'][] = $month->format('M Y');
            $purchaseTrend['values'][] = (int) $amount;
        }

        // View logic
        $viewName = "pages.dashboard.{$role}";
        if (!view()->exists($viewName)) {
            $viewName = 'pages.dashboard.ecommerce';
        }

        return view($viewName, compact(
            'stats', 
            'recentSales', 
            'recentPurchases', 
            'recentProducts', 
            'chartData', 
            'pieChartData',
            'lowStockProducts',
            'pendingShipments',
            'incomingGoods',
            'movementChart',
            'pendingPayments',
            'pendingPurchases',
            'totalReceivables',
            'totalPayables',
            'financeChart',
            'vendorPerformance',
            'purchaseTrend'
        ));
    }
}
