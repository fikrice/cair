@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Laporan Inventaris & Aset</h2>
            <p class="text-sm text-gray-500">Pemantauan real-time nilai kekayaan stok yang tersimpan di gudang.</p>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li class="font-medium text-brand-500">Laporan Inventaris</li>
            </ol>
        </nav>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/10 mb-4">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Jenis Produk</p>
            <h4 class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $summary['total_products'] }} <span class="text-sm font-normal text-gray-400">Items</span></h4>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-500 dark:bg-blue-500/10 mb-4">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
            </div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Total Unit</p>
            <h4 class="text-xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ number_format($summary['total_stock'], 0, ',', '.') }} <span class="text-sm font-normal text-gray-400">Pcs</span></h4>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning-50 text-warning-500 dark:bg-warning-500/10 mb-4">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Stok Menipis</p>
            <h4 class="text-xl font-bold text-warning-600 dark:text-warning-400 mt-1">{{ $summary['low_stock_items'] }} <span class="text-sm font-normal text-gray-400">Items</span></h4>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-success-50 text-success-500 dark:bg-success-500/10 mb-4">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Nilai Aset</p>
            <h4 class="text-xl font-bold text-success-600 dark:text-success-400 mt-1">Rp {{ number_format($summary['total_asset_value'], 0, ',', '.') }}</h4>
        </div>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col gap-4 px-5 py-5 sm:px-6 sm:py-6 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Ketersediaan Stok & Valuasi Barang</h3>
            <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="inline-flex items-center gap-2 rounded-xl bg-error-500 px-6 py-2.5 text-sm font-bold text-white hover:bg-error-600 transition shadow-theme-md active:scale-95">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M7 13l5 5 5-5M12 18V9"/></svg>
                Export Laporan (PDF)
            </a>
        </div>
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-y border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-start text-xs font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-5 py-3 text-start text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Sisa Stok</th>
                        <th class="px-5 py-3 text-end text-xs font-bold text-gray-400 uppercase tracking-wider">Harga Beli</th>
                        <th class="px-5 py-3 text-end text-xs font-bold text-gray-400 uppercase tracking-wider">Nilai Aset</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $product->name }}</span>
                                <span class="text-[10px] text-brand-500 font-mono font-bold uppercase tracking-tighter">{{ $product->sku }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $product->category->name }}</td>
                        <td class="px-5 py-4 text-center font-mono font-bold text-gray-900 dark:text-white">{{ $product->stock }}</td>
                        <td class="px-5 py-4 text-end text-sm text-gray-600 dark:text-gray-400">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-end font-bold text-gray-900 dark:text-white">Rp {{ number_format($product->stock * $product->purchase_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-center">
                            @if($product->stock <= 0)
                                <span class="inline-flex rounded-full bg-error-50 px-2.5 py-0.5 text-[10px] font-bold text-error-600 dark:bg-error-500/10 uppercase">Kosong</span>
                            @elseif($product->stock <= $product->min_stock)
                                <span class="inline-flex rounded-full bg-warning-50 px-2.5 py-0.5 text-[10px] font-bold text-warning-600 dark:bg-warning-500/10 uppercase">Menipis</span>
                            @else
                                <span class="inline-flex rounded-full bg-success-50 px-2.5 py-0.5 text-[10px] font-bold text-success-600 dark:bg-success-500/10 uppercase">Aman</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <tr class="font-bold">
                        <td colspan="4" class="px-5 py-4 text-end text-xs text-gray-500 uppercase tracking-widest">Akumulasi Nilai Seluruh Barang</td>
                        <td class="px-5 py-4 text-end text-base text-success-600 dark:text-success-400">Rp {{ number_format($summary['total_asset_value'], 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
