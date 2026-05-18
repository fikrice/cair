@extends('layouts.app')

@section('content')
  <!-- Dashboard Hero Section -->
  <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Dashboard Intelligence : Admin</h1>
        <p class="text-sm font-medium text-gray-500">Monitoring performa bisnis, kesehatan stok, dan arus kas secara real-time.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="h-10 px-4 rounded-xl bg-white border border-gray-100 flex items-center justify-center shadow-theme-xs dark:bg-white/5 dark:border-gray-800">
            <span class="text-xs font-black text-brand-600 uppercase tracking-widest">{{ now()->format('d M Y') }}</span>
        </div>
    </div>
  </div>

  <!-- Top Metrics Row -->
  <div class="mb-8">
    <x-ecommerce.ecommerce-metrics :stats="$stats" />
  </div>

  <div class="grid grid-cols-12 gap-6 md:gap-8 mb-8">
    <!-- Main Revenue Analytics - 2/3 Width -->
    <div class="col-span-12 xl:col-span-8">
        <div class="h-full rounded-3xl border border-gray-200 bg-white p-8 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">Revenue Analytics</h3>
                    <p class="text-xs font-medium text-gray-500">Performa pendapatan kotor dalam 6 bulan terakhir.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="flex h-3 w-3 rounded-full bg-brand-500"></span>
                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Gross Revenue</span>
                </div>
            </div>
            <x-ecommerce.statistics-chart />
        </div>
    </div>

    <!-- Stock Distribution Pie Chart - 1/3 Width -->
    <div class="col-span-12 xl:col-span-4">
        <x-ecommerce.stock-distribution-chart :data="$pieChartData" />
    </div>
  </div>

  <div class="grid grid-cols-12 gap-6 md:gap-8">
    <!-- Recent Activity / Orders -->
    <div class="col-span-12 xl:col-span-8">
        <x-ecommerce.recent-orders :orders="$recentSales" />
    </div>

    <!-- Sidebar Info Panel -->
    <div class="col-span-12 xl:col-span-4 space-y-6">
        <!-- Quick Stats Cards -->
        <div class="group relative overflow-hidden rounded-3xl bg-gray-900 p-8 shadow-xl shadow-gray-900/20 text-white">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[3px] mb-2">Business Liquidity</p>
                <h3 class="text-3xl font-black mb-4">Rp {{ number_format($stats['totalSales'], 0, ',', '.') }}</h3>
                <div class="flex items-center gap-2 text-[10px] font-black bg-white/10 w-fit px-3 py-1 rounded-lg">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    TOTAL SALES
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/5 rotate-12">
                <svg width="140" height="140" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">Action Items</h4>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-100 dark:border-amber-500/20">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-amber-500 text-white flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                        </div>
                        <span class="text-xs font-black text-amber-700 dark:text-amber-400 uppercase tracking-tighter">Processing Sales</span>
                    </div>
                    <span class="text-lg font-black text-amber-900 dark:text-amber-200">{{ $stats['pendingSO'] }}</span>
                </div>
                
                <div class="flex items-center justify-between p-4 rounded-2xl bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-brand-500 text-white flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <span class="text-xs font-black text-brand-700 dark:text-brand-400 uppercase tracking-tighter">Active Purchase</span>
                    </div>
                    <span class="text-lg font-black text-brand-900 dark:text-brand-200">{{ $stats['pendingPO'] }}</span>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
