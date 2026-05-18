@props(['stats' => [
    'totalProducts' => 0,
    'totalCategories' => 0,
    'totalStock' => 0,
    'lowStockCount' => 0,
    'totalSales' => 0,
    'totalPurchase' => 0,
]])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 md:gap-6">
    <!-- Revenue Card -->
    <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 shadow-theme-xs group hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-center w-12 h-12 bg-brand-50 rounded-xl dark:bg-brand-500/10 mb-5 group-hover:scale-110 transition-transform">
            <svg class="text-brand-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Revenue</span>
            <h4 class="mt-2 text-xl font-black text-gray-900 dark:text-white">Rp {{ number_format($stats['totalSales'], 0, ',', '.') }}</h4>
            <div class="mt-3 flex items-center gap-1">
                <span class="text-[10px] font-bold text-success-600 bg-success-50 px-2 py-0.5 rounded-full dark:bg-success-500/10">Active Earnings</span>
            </div>
        </div>
    </div>

    <!-- Procurement Card -->
    <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 shadow-theme-xs group hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-center w-12 h-12 bg-error-50 rounded-xl dark:bg-error-500/10 mb-5 group-hover:scale-110 transition-transform">
            <svg class="text-error-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
        </div>
        <div>
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Stock Procurement</span>
            <h4 class="mt-2 text-xl font-black text-gray-900 dark:text-white">Rp {{ number_format($stats['totalPurchase'], 0, ',', '.') }}</h4>
            <div class="mt-3 flex items-center gap-1">
                <span class="text-[10px] font-bold text-error-600 bg-error-50 px-2 py-0.5 rounded-full dark:bg-error-500/10">Inventory Cost</span>
            </div>
        </div>
    </div>

    <!-- Inventory Asset Card -->
    <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 shadow-theme-xs group hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-center w-12 h-12 bg-success-50 rounded-xl dark:bg-success-500/10 mb-5 group-hover:scale-110 transition-transform">
            <svg class="text-success-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <div>
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Physical Stock</span>
            <h4 class="mt-2 text-xl font-black text-gray-900 dark:text-white">{{ number_format($stats['totalStock']) }} Units</h4>
            <div class="mt-3 flex items-center gap-1">
                <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full dark:bg-gray-800">{{ $stats['totalProducts'] }} SKUs</span>
            </div>
        </div>
    </div>

    <!-- Efficiency Card -->
    <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 shadow-theme-xs group hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-center w-12 h-12 bg-amber-50 rounded-xl dark:bg-amber-500/10 mb-5 group-hover:scale-110 transition-transform">
            <svg class="text-amber-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div>
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Low Stock Alert</span>
            <h4 class="mt-2 text-xl font-black text-gray-900 dark:text-white">{{ number_format($stats['lowStockCount']) }} SKU</h4>
            <div class="mt-3 flex items-center gap-1">
                @if($stats['lowStockCount'] > 0)
                    <span class="text-[10px] font-black text-error-600 bg-error-50 px-2 py-0.5 rounded-full dark:bg-error-500/10 animate-pulse">Critical Restock</span>
                @else
                    <span class="text-[10px] font-bold text-success-600 bg-success-50 px-2 py-0.5 rounded-full dark:bg-success-500/10">Stock Healthy</span>
                @endif
            </div>
        </div>
    </div>
</div>