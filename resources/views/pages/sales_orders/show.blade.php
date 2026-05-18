@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail Sales Order</h2>
                @switch($salesOrder->status)
                    @case('draft')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Draft
                        </span>
                        @break
                    @case('processing')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-50 px-3 py-1 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-warning-500 animate-pulse"></span> Processing
                        </span>
                        @break
                    @case('completed')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> Completed
                        </span>
                        @break
                @endswitch
            </div>
            <p class="mt-1 text-sm text-gray-500 font-mono font-bold">{{ $salesOrder->so_number }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if($salesOrder->status === 'completed')
                <div class="flex items-center gap-2 mr-2 border-r border-gray-200 pr-4 dark:border-gray-800">
                    <a href="{{ route('sales-orders.print', $salesOrder) }}" 
                        class="inline-flex items-center gap-2 rounded-lg bg-white border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        Invoice
                    </a>
                    <a href="{{ route('sales-orders.shipping-label', $salesOrder) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-white border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polyline points="16 8 20 8 23 11 23 16 16 16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        Surat Jalan
                    </a>
                </div>
            @endif

            @php
                $isStockConfirmed = \App\Models\StockMovement::where('reference', $salesOrder->so_number)->exists();
            @endphp

            @if($salesOrder->status === 'processing' && !$isStockConfirmed && auth()->user()->role === 'warehouse')
                @if($salesOrder->payment_status === 'paid')
                    <form action="{{ route('sales-orders.complete', $salesOrder) }}" method="POST" x-ref="completeForm">
                        @csrf
                        <button type="button" @click="$dispatch('confirm', { title: 'Konfirmasi & Siapkan?', message: 'Stok akan dikurangi dan pesanan dinyatakan Selesai (Completed).', confirmText: 'Ya, Kirim', type: 'success', onConfirm: () => $refs.completeForm.submit() })"
                            class="inline-flex items-center gap-2 rounded-lg bg-success-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-success-700 transition shadow-theme-xs">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                            Siapkan & Kirim Barang
                        </button>
                    </form>
                @else
                    <button type="button" disabled class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-5 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Menunggu Pembayaran Customer
                    </button>
                @endif
            @elseif($salesOrder->status === 'processing' && $isStockConfirmed)
                <div class="inline-flex items-center gap-2 rounded-lg bg-success-50 px-4 py-2 text-sm font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400 border border-success-200 dark:border-success-500/20">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17 4 12"/></svg>
                    Stok Siap & Dikirim
                </div>
            @endif

            @if(in_array($salesOrder->status, ['draft', 'processing']) && auth()->user()->role !== 'warehouse')
                <form action="{{ route('sales-orders.cancel', $salesOrder) }}" method="POST" x-ref="cancelForm">
                    @csrf
                    <button type="button" @click="$dispatch('confirm', { title: 'Batalkan Pesanan?', message: 'Status akan diubah ke Dibatalkan. Tindakan ini tidak dapat diubah.', confirmText: 'Ya, Batalkan', type: 'danger', onConfirm: () => $refs.cancelForm.submit() })"
                        class="inline-flex h-10 items-center justify-center rounded-lg border border-error-200 bg-white px-4 text-sm font-medium text-error-600 hover:bg-error-50 transition dark:border-error-800 dark:bg-transparent dark:text-error-400">
                        Batalkan
                    </button>
                </form>
            @endif

            <a href="{{ route('sales-orders.index') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </a>
        </div>
    </div>

    <!-- Status Stepper -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="relative flex items-center justify-between">
            <div class="absolute left-0 top-1/2 h-0.5 w-full -translate-y-1/2 bg-gray-100 dark:bg-gray-800"></div>
            <div class="absolute left-0 top-1/2 h-0.5 -translate-y-1/2 bg-brand-500 transition-all duration-500" 
                style="width: {{ $salesOrder->status === 'completed' ? '100%' : ($salesOrder->status === 'processing' ? '50%' : '0%') }}"></div>

            <div class="relative flex flex-col items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 bg-white transition duration-300 dark:bg-gray-900 {{ in_array($salesOrder->status, ['draft', 'processing', 'completed']) ? 'border-brand-500 text-brand-500 shadow-lg shadow-brand-500/20' : 'border-gray-200 text-gray-400 dark:border-gray-800' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <span class="text-xs font-bold {{ in_array($salesOrder->status, ['draft', 'processing', 'completed']) ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Draft</span>
            </div>
            <div class="relative flex flex-col items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 bg-white transition duration-300 dark:bg-gray-900 {{ in_array($salesOrder->status, ['processing', 'completed']) ? 'border-brand-500 text-brand-500 shadow-lg shadow-brand-500/20' : 'border-gray-200 text-gray-400 dark:border-gray-800' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="text-xs font-bold {{ in_array($salesOrder->status, ['processing', 'completed']) ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Proses</span>
            </div>
            <div class="relative flex flex-col items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 bg-white transition duration-300 dark:bg-gray-900 {{ $salesOrder->status === 'completed' ? 'border-success-500 text-success-500 shadow-lg shadow-success-500/20' : 'border-gray-200 text-gray-400 dark:border-gray-800' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <span class="text-xs font-bold {{ $salesOrder->status === 'completed' ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Selesai</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <!-- Main Content (2/3) -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Items Table -->
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        {{ auth()->user()->role === 'warehouse' ? 'Daftar Pengambilan Barang (Pick List)' : 'Rincian Penjualan' }}
                    </h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 dark:bg-white/[0.02] dark:text-gray-400">
                                <th class="px-6 py-3 text-start font-medium">Produk</th>
                                @if(auth()->user()->role === 'warehouse')
                                    <th class="px-6 py-3 text-center font-medium">Stok Tersedia</th>
                                @endif
                                <th class="px-6 py-3 text-center font-medium">Qty Pesanan</th>
                                @if(auth()->user()->role !== 'warehouse')
                                    <th class="px-6 py-3 text-end font-medium">Harga Satuan</th>
                                    <th class="px-6 py-3 text-end font-medium">Subtotal</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($salesOrder->items as $item)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 overflow-hidden rounded-lg border border-gray-100 dark:border-gray-700">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-gray-50 text-gray-400 dark:bg-gray-800">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-900 dark:text-white">{{ $item->product->name }}</span>
                                                <span class="text-[10px] text-brand-500 font-mono font-bold uppercase">{{ $item->product->sku }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    @if(auth()->user()->role === 'warehouse')
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-sm font-medium {{ $item->product->stock < $item->quantity ? 'text-error-600 font-bold' : 'text-gray-600 dark:text-gray-400' }}">
                                                {{ $item->product->stock }} unit
                                            </span>
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                            {{ $item->quantity }} unit
                                        </span>
                                    </td>
                                    @if(auth()->user()->role !== 'warehouse')
                                        <td class="px-6 py-4 text-end text-gray-600 dark:text-gray-400">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-end font-bold text-gray-900 dark:text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(auth()->user()->role !== 'warehouse')
                    <div class="px-6 py-6 bg-brand-50/30 dark:bg-brand-500/5 border-t border-gray-100 dark:border-gray-800 rounded-b-2xl">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total Bayar</span>
                            <span class="text-2xl font-black text-brand-600 dark:text-brand-400">Rp {{ number_format($salesOrder->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Notes -->
            @if($salesOrder->notes)
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest">Catatan</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 italic">"{{ $salesOrder->notes }}"</p>
            </div>
            @endif

            <!-- Payment History -->
            @if(auth()->user()->role !== 'warehouse')
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Riwayat Pembayaran</h3>
                    @if($salesOrder->payment_status !== 'paid' && $salesOrder->status === 'processing' && in_array(auth()->user()->role, ['admin', 'finance']))
                        <a href="{{ route('sales-orders.payment', $salesOrder) }}" 
                            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-xs font-bold text-white hover:bg-brand-600 transition shadow-theme-xs">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Bayar Sekarang
                        </a>
                    @endif
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 dark:bg-white/[0.02] dark:text-gray-400">
                                <th class="px-6 py-3 text-start font-medium">Tanggal</th>
                                <th class="px-6 py-3 text-start font-medium">Metode</th>
                                <th class="px-6 py-3 text-end font-medium">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($salesOrder->transactions as $trx)
                                <tr>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">{{ $trx->payment_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-[10px] font-bold uppercase
                                            {{ $trx->payment_method === 'cash' ? 'bg-orange-50 text-orange-700 dark:bg-orange-500/10' : '' }}
                                            {{ $trx->payment_method === 'transfer' ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10' : '' }}
                                            {{ $trx->payment_method === 'e-wallet' ? 'bg-purple-50 text-purple-700 dark:bg-purple-500/10' : '' }}
                                        ">
                                            {{ $trx->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-end font-bold text-gray-900 dark:text-white">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">Belum ada catatan pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($salesOrder->transactions->count() > 0)
                            <tfoot class="border-t border-gray-100 dark:border-gray-800">
                                <tr class="font-bold text-gray-900 dark:text-white">
                                    <td colspan="2" class="px-6 py-3 text-end uppercase text-[10px] tracking-widest text-gray-500">Total Terbayar</td>
                                    <td class="px-6 py-3 text-end">Rp {{ number_format($salesOrder->transactions->sum('amount'), 0, ',', '.') }}</td>
                                </tr>
                                @if($salesOrder->payment_status !== 'paid')
                                <tr class="font-bold text-error-600">
                                    <td colspan="2" class="px-6 py-3 text-end uppercase text-[10px] tracking-widest text-gray-500">Sisa Tagihan</td>
                                    <td class="px-6 py-3 text-end">Rp {{ number_format($salesOrder->total_amount - $salesOrder->transactions->sum('amount'), 0, ',', '.') }}</td>
                                </tr>
                                @endif
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar (1/3) -->
        <div class="space-y-6">
            <!-- Pelanggan -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Pelanggan</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/10 font-bold text-lg">
                        {{ substr($salesOrder->customer_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $salesOrder->customer_name }}</p>
                        <p class="text-xs text-gray-500">{{ $salesOrder->customer_phone ?: '-' }}</p>
                    </div>
                </div>
                <div class="space-y-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-500 uppercase">Alamat Pengiriman</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $salesOrder->shipping_address ?: 'Tidak ada alamat.' }}</span>
                    </div>
                </div>
            </div>

            <!-- Logistik -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Logistik & Pembuat</h3>
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-500 uppercase">Tanggal Pesanan</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $salesOrder->so_date->format('d F Y') }}</span>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center gap-3">
                        <div class="h-8 w-8 overflow-hidden rounded-full border border-gray-100 dark:border-gray-800 shadow-sm">
                            @if($salesOrder->creator->avatar)
                                <img src="{{ asset('storage/' . $salesOrder->creator->avatar) }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gray-50 text-brand-600 dark:bg-gray-800 dark:text-brand-400 font-bold text-[10px]">
                                    {{ substr($salesOrder->creator->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-400 uppercase">Kasir / Admin</span>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $salesOrder->creator->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
