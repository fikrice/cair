@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Sales Intelligence</h1>
            <p class="text-sm font-medium text-gray-500">Monitor pendapatan, tren transaksi, dan realisasi kas secara real-time.</p>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-bold text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">ERP /</a></li>
                <li class="font-bold text-brand-500">Sales Analytics</li>
            </ol>
        </nav>
    </div>

    <!-- Analytics Dashboard Header -->
    <div class="flex flex-col gap-6 mb-8 lg:flex-row">
        <!-- Filter Card - More Integrated -->
        <div class="w-full lg:w-80 shrink-0">
            <div class="h-full rounded-3xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500 text-white shadow-lg shadow-brand-500/20">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18M6 12h12m-9 6h6"/></svg>
                    </div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">Control Panel</h3>
                </div>
                
                <form action="{{ route('reports.sales') }}" method="GET" class="space-y-6">
                    <div x-data="{
                        init() {
                            flatpickr($refs.startDate, { altInput: true, altFormat: 'd M Y', dateFormat: 'Y-m-d' });
                            flatpickr($refs.endDate, { altInput: true, altFormat: 'd M Y', dateFormat: 'Y-m-d' });
                        }
                    }">
                        <div class="space-y-4">
                            <div class="relative">
                                <label class="mb-2 block text-[10px] font-black text-gray-400 uppercase tracking-widest">Start Period</label>
                                <div class="relative group">
                                    <input x-ref="startDate" type="text" name="start_date" value="{{ $startDate }}" 
                                        class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50/50 py-3.5 pl-12 pr-4 text-sm font-bold text-gray-900 focus:border-brand-500 focus:bg-white focus:ring-0 dark:border-gray-800 dark:bg-gray-900 dark:text-white transition-all cursor-pointer">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-500">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <label class="mb-2 block text-[10px] font-black text-gray-400 uppercase tracking-widest">End Period</label>
                                <div class="relative group">
                                    <input x-ref="endDate" type="text" name="end_date" value="{{ $endDate }}" 
                                        class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50/50 py-3.5 pl-12 pr-4 text-sm font-bold text-gray-900 focus:border-brand-500 focus:bg-white focus:ring-0 dark:border-gray-800 dark:bg-gray-900 dark:text-white transition-all cursor-pointer">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-500">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 pt-4">
                        <button type="submit" class="w-full rounded-2xl bg-brand-500 py-4 text-xs font-black text-white hover:bg-brand-600 transition shadow-xl shadow-brand-500/25 active:scale-95 uppercase tracking-widest">
                            Apply Analytics
                        </button>
                        <a href="{{ route('reports.sales') }}" class="w-full inline-flex items-center justify-center rounded-2xl border-2 border-gray-100 bg-white py-3.5 text-xs font-bold text-gray-400 hover:bg-gray-50 transition dark:border-gray-800 dark:bg-transparent uppercase tracking-widest">
                            Reset View
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Metric Section - Rich & Dense -->
        <div class="flex-1">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 h-full">
                <!-- Total Orders -->
                <div class="relative overflow-hidden rounded-3xl border border-gray-200 bg-white p-8 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="relative z-10">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 mb-6 group-hover:scale-110 transition-transform">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        </div>
                        <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-2">Total Transaksi</h4>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-black text-gray-900 dark:text-white">{{ $summary['total_orders'] }}</span>
                            <span class="text-xs font-bold text-gray-400">Order</span>
                        </div>
                        <p class="mt-4 text-xs font-medium text-gray-500 leading-relaxed">Akumulasi volume pesanan yang berhasil diselesaikan pada periode ini.</p>
                    </div>
                    <!-- Decorative Element -->
                    <div class="absolute -right-6 -bottom-6 text-brand-500/5 rotate-12">
                        <svg width="120" height="120" viewBox="0 0 24 24" fill="currentColor"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/></svg>
                    </div>
                </div>

                <!-- Sales Revenue -->
                <div class="relative overflow-hidden rounded-3xl border border-gray-200 bg-white p-8 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="relative z-10">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-success-50 text-success-600 dark:bg-success-500/10 mb-6">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-2">Nilai Penjualan</h4>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-success-600 mb-1">Gross Revenue</span>
                            <span class="text-3xl font-black text-gray-900 dark:text-white leading-tight">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</span>
                        </div>
                        <p class="mt-4 text-xs font-medium text-gray-500 leading-relaxed">Total nilai piutang dari seluruh Sales Order yang telah diterbitkan.</p>
                    </div>
                    <div class="absolute -right-6 -bottom-6 text-success-500/5 rotate-12">
                        <svg width="120" height="120" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                </div>

                <!-- Cash In -->
                <div class="relative overflow-hidden rounded-3xl border border-gray-200 bg-white p-8 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="relative z-10">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 mb-6">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-2">Realisasi Kas</h4>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-blue-600 mb-1">Liquid Cash In</span>
                            <span class="text-3xl font-black text-gray-900 dark:text-white leading-tight">Rp {{ number_format($summary['total_paid'], 0, ',', '.') }}</span>
                        </div>
                        <p class="mt-4 text-xs font-medium text-gray-500 leading-relaxed">Jumlah pembayaran yang sudah diterima dan tervalidasi oleh sistem.</p>
                    </div>
                    <div class="absolute -right-6 -bottom-6 text-blue-500/5 rotate-12">
                        <svg width="120" height="120" viewBox="0 0 24 24" fill="currentColor"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card - Premium Finish -->
    <div class="rounded-3xl border border-gray-200 bg-white shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="flex flex-col gap-4 px-8 py-8 sm:flex-row sm:items-center sm:justify-between bg-gray-50/50 dark:bg-white/[0.02]">
            <div>
                <h3 class="text-lg font-black text-gray-900 dark:text-white">Transaction Logs</h3>
                <p class="text-xs font-medium text-gray-500">Rincian detail per transaksi penjualan pada periode terpilih.</p>
            </div>
            <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="inline-flex items-center gap-3 rounded-2xl bg-error-500 px-8 py-3.5 text-xs font-black text-white hover:bg-error-600 transition shadow-xl shadow-error-500/25 active:scale-95 uppercase tracking-widest">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M7 13l5 5 5-5M12 18V9"/></svg>
                Download PDF Report
            </a>
        </div>
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white dark:bg-transparent">
                        <th class="px-8 py-5 text-start text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 w-16">#</th>
                        <th class="px-8 py-5 text-start text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800">Date</th>
                        <th class="px-8 py-5 text-start text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800">SO Number</th>
                        <th class="px-8 py-5 text-start text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800">Client / Customer</th>
                        <th class="px-8 py-5 text-start text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800">Sales PIC</th>
                        <th class="px-8 py-5 text-end text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800">Net Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($salesOrders as $so)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors group">
                        <td class="px-8 py-5 text-sm font-bold text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-8 py-5 text-sm font-bold text-gray-900 dark:text-white">{{ $so->so_date->format('d M, Y') }}</td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-brand-50 text-brand-700 text-sm font-black dark:bg-brand-500/10 dark:text-brand-400 font-mono">
                                {{ $so->so_number }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $so->customer_name }}</span>
                                <span class="text-xs font-bold text-gray-400">Regular Client</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs font-black text-gray-600 border border-gray-200 dark:border-gray-700">
                                    {{ substr($so->creator->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $so->creator->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-end font-black text-gray-900 dark:text-white text-base">
                            Rp {{ number_format($so->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                </div>
                                <p class="text-base font-bold text-gray-400">No transactions found for this period.</p>
                                <p class="text-xs text-gray-400 mt-1">Try adjusting your date filters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($salesOrders->count() > 0)
                <tfoot class="bg-gray-900 dark:bg-white/[0.05]">
                    <tr class="font-black">
                        <td colspan="5" class="px-8 py-6 text-end text-xs text-gray-400 uppercase tracking-[3px]">Consolidated Total Revenue</td>
                        <td class="px-8 py-6 text-end text-xl text-white">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection
