@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail Purchase Order</h2>
                @switch($purchaseOrder->status)
                    @case('draft')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Draft
                        </span>
                        @break
                    @case('pending')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-50 px-3 py-1 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-warning-500 animate-pulse"></span> Pending
                        </span>
                        @break
                    @case('received')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> Received
                        </span>
                        @break
                @endswitch

                {{-- Payment Status Badge --}}
                @switch($purchaseOrder->payment_status)
                    @case('unpaid')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-error-50 px-3 py-1 text-[10px] font-bold text-error-600 uppercase tracking-widest dark:bg-error-500/10 dark:text-error-400">
                            Belum Bayar
                        </span>
                        @break
                    @case('partial')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-50 px-3 py-1 text-[10px] font-bold text-warning-600 uppercase tracking-widest dark:bg-warning-500/10 dark:text-warning-400">
                            Cicil / Partial
                        </span>
                        @break
                    @case('paid')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-[10px] font-bold text-blue-600 uppercase tracking-widest dark:bg-blue-500/10 dark:text-blue-400">
                            Lunas
                        </span>
                        @break
                @endswitch
            </div>
            <p class="mt-1 text-sm text-gray-500 font-mono font-bold">{{ $purchaseOrder->po_number }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if(in_array($purchaseOrder->status, ['pending', 'received']) && in_array(auth()->user()->role, ['admin', 'purchasing', 'finance']))
                <a href="{{ route('purchase-orders.print', $purchaseOrder) }}" 
                    class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400">
                    <svg class="mr-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak PO
                </a>
            @endif

            @if($purchaseOrder->status === 'draft' && in_array(auth()->user()->role, ['admin', 'purchasing']))
                <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition shadow-theme-xs">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M12.75 3L15 5.25M14.25 1.5L16.5 3.75L6.75 13.5H4.5V11.25L14.25 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Edit PO
                </a>
            @endif
            
            @if(in_array($purchaseOrder->status, ['draft', 'pending']) && in_array(auth()->user()->role, ['admin', 'purchasing']))
                <form action="{{ route('purchase-orders.cancel', $purchaseOrder) }}" method="POST" x-ref="cancelForm">
                    @csrf
                    <button type="button" @click="$dispatch('confirm', { title: 'Batalkan Purchase Order?', message: 'Status akan diubah ke Dibatalkan. Tindakan ini tidak dapat diubah.', confirmText: 'Ya, Batalkan', type: 'danger', onConfirm: () => $refs.cancelForm.submit() })"
                        class="inline-flex h-10 items-center justify-center rounded-lg border border-error-200 bg-white px-4 text-sm font-medium text-error-600 hover:bg-error-50 transition dark:border-error-800 dark:bg-transparent dark:text-error-400">
                        Batalkan
                    </button>
                </form>
            @endif

            {{-- BUTTON BAYAR UNTUK FINANCE --}}
            @if($purchaseOrder->status === 'pending' && $purchaseOrder->payment_status !== 'paid' && in_array(auth()->user()->role, ['admin', 'finance']))
                <a href="{{ route('purchase-orders.payment', $purchaseOrder) }}" 
                    class="inline-flex items-center gap-2 rounded-lg bg-error-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-error-700 transition shadow-lg shadow-error-500/20 active:scale-95">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22M17 19H9.5a3.5 3.5 0 0 1 0-7h5a3.5 3.5 0 0 0 0-7H6"/></svg>
                    Bayar Tagihan
                </a>
            @endif

            {{-- HANYA MUNCUL JIKA STATUS PENDING UNTUK WAREHOUSE --}}
            @if(trim(strtolower($purchaseOrder->status)) === 'pending' && in_array(auth()->user()->role, ['admin', 'warehouse']))
                @if($purchaseOrder->payment_status === 'paid')
                    <form action="{{ route('purchase-orders.receive', $purchaseOrder) }}" method="POST" x-ref="receiveForm">
                        @csrf
                        <button type="button" @click="$dispatch('confirm', { title: 'Terima Barang?', message: 'Barang akan diterima dan stok akan bertambah secara otomatis.', confirmText: 'Ya, Terima', type: 'success', onConfirm: () => $refs.receiveForm.submit() })"
                            class="inline-flex items-center gap-2 rounded-lg bg-success-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-success-700 transition shadow-theme-xs">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                            Konfirmasi Terima
                        </button>
                    </form>
                @else
                    <button type="button" disabled class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-5 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Menunggu Pelunasan Finance
                    </button>
                @endif
            @endif

            <a href="{{ route('purchase-orders.index') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </a>
        </div>
    </div>

    <!-- Status Stepper -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="relative flex items-center justify-between">
            <!-- Line Background -->
            <div class="absolute left-0 top-1/2 h-0.5 w-full -translate-y-1/2 bg-gray-100 dark:bg-gray-800"></div>
            <!-- Progress Line -->
            <div class="absolute left-0 top-1/2 h-0.5 -translate-y-1/2 bg-brand-500 transition-all duration-500" 
                style="width: {{ $purchaseOrder->status === 'received' ? '100%' : ($purchaseOrder->status === 'pending' ? '50%' : '0%') }}"></div>

            <!-- Steps -->
            <div class="relative flex flex-col items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 bg-white transition duration-300 dark:bg-gray-900 {{ in_array($purchaseOrder->status, ['draft', 'pending', 'received']) ? 'border-brand-500 text-brand-500 shadow-lg shadow-brand-500/20' : 'border-gray-200 text-gray-400 dark:border-gray-800' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <span class="text-xs font-bold {{ in_array($purchaseOrder->status, ['draft', 'pending', 'received']) ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Draft PO</span>
            </div>
            <div class="relative flex flex-col items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 bg-white transition duration-300 dark:bg-gray-900 {{ in_array($purchaseOrder->status, ['pending', 'received']) ? 'border-brand-500 text-brand-500 shadow-lg shadow-brand-500/20' : 'border-gray-200 text-gray-400 dark:border-gray-800' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                </div>
                <span class="text-xs font-bold {{ in_array($purchaseOrder->status, ['pending', 'received']) ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Terkirim</span>
            </div>
            <div class="relative flex flex-col items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 bg-white transition duration-300 dark:bg-gray-900 {{ $purchaseOrder->status === 'received' ? 'border-success-500 text-success-500 shadow-lg shadow-success-500/20' : 'border-gray-200 text-gray-400 dark:border-gray-800' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
                <span class="text-xs font-bold {{ $purchaseOrder->status === 'received' ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Diterima</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <!-- Main Content (2/3) -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Items Table -->
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Rincian Produk</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 dark:bg-white/[0.02] dark:text-gray-400">
                                <th class="px-6 py-3 text-start font-medium">Produk</th>
                                <th class="px-6 py-3 text-center font-medium">Qty</th>
                                <th class="px-6 py-3 text-end font-medium">Harga Satuan</th>
                                <th class="px-6 py-3 text-end font-medium">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($purchaseOrder->items as $item)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-all duration-200 group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="relative h-12 w-12 flex-shrink-0 overflow-hidden rounded-xl border border-gray-100 bg-gray-50 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900 group-hover:scale-105 transition-transform duration-300">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-gray-400">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col gap-0.5">
                                                <span class="font-bold text-gray-900 dark:text-white/90 leading-tight">{{ $item->product->name }}</span>
                                                <span class="text-[10px] text-brand-500 font-mono uppercase tracking-widest font-bold">{{ $item->product->sku }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                            {{ $item->quantity }} {{ $item->product->unit }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-end text-gray-600 dark:text-gray-400">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-end font-bold text-gray-900 dark:text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Grand Total Footer -->
                <div class="px-6 py-6 bg-brand-50/30 dark:bg-brand-500/5 border-t border-gray-100 dark:border-gray-800 rounded-b-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total Pembayaran</span>
                            <span class="text-xs text-gray-400 italic">Sudah termasuk pajak & biaya lainnya</span>
                        </div>
                        <div class="text-end">
                            <span class="text-2xl font-black text-brand-600 dark:text-brand-400">Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($purchaseOrder->notes)
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="text-gray-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Catatan Internal</h3>
                </div>
                <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed italic">"{{ $purchaseOrder->notes }}"</p>
                </div>
            </div>
            @endif

            {{-- PAYMENT HISTORY (FINANCE ONLY) --}}
            @if(in_array(auth()->user()->role, ['admin', 'finance']))
                <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="text-error-500" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22M17 19H9.5a3.5 3.5 0 0 1 0-7h5a3.5 3.5 0 0 0 0-7H6"/></svg>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-tight">Riwayat Pelunasan Tagihan</h3>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Finance View</span>
                    </div>
                    
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50/30 text-gray-500 dark:bg-white/[0.01] dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-6 py-3 text-start font-medium">Tanggal</th>
                                    <th class="px-6 py-3 text-start font-medium">Referensi</th>
                                    <th class="px-6 py-3 text-start font-medium">Metode</th>
                                    <th class="px-6 py-3 text-end font-medium">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @php $totalPaid = 0; @endphp
                                @forelse($purchaseOrder->transactions as $trx)
                                    @php $totalPaid += $trx->amount; @endphp
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400 font-medium">{{ $trx->payment_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $trx->reference_number }}</span>
                                                <span class="text-[10px] text-gray-400 italic">{{ $trx->description }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 uppercase text-[10px] font-bold tracking-widest text-gray-500">{{ $trx->payment_method }}</td>
                                        <td class="px-6 py-4 text-end font-bold text-error-600">- Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">Belum ada catatan pembayaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($purchaseOrder->payment_status !== 'paid')
                        <div class="px-6 py-4 bg-error-50/50 dark:bg-error-500/5 flex items-center justify-between border-t border-error-100 dark:border-error-500/10">
                            <span class="text-xs font-bold text-error-700 dark:text-error-400 uppercase tracking-widest">Sisa Hutang Ke Supplier</span>
                            <span class="text-lg font-black text-error-600">Rp {{ number_format($purchaseOrder->total_amount - $totalPaid, 0, ',', '.') }}</span>
                        </div>
                    @else
                        <div class="px-6 py-4 bg-success-50/50 dark:bg-success-500/5 flex items-center justify-center border-t border-success-100 dark:border-success-500/10">
                            <span class="text-xs font-bold text-success-700 dark:text-success-400 uppercase tracking-widest flex items-center gap-2">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                Tagihan Sudah Lunas Sepenuhnya
                            </span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar Info (1/3) -->
        <div class="space-y-6">
            <!-- Supplier Card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Supplier</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-500 dark:bg-brand-500/10 font-bold text-xl">
                        {{ substr($purchaseOrder->supplier->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $purchaseOrder->supplier->name }}</p>
                        <span class="inline-flex rounded-lg bg-brand-50 px-2 py-0.5 text-[10px] font-bold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 uppercase tracking-tighter">{{ $purchaseOrder->supplier->code }}</span>
                    </div>
                </div>
                <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800">
                            <svg class="text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $purchaseOrder->supplier->phone ?: 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800">
                            <svg class="text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $purchaseOrder->supplier->email ?: 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Logistics Card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Informasi Logistik</h3>
                    @if($purchaseOrder->status === 'received')
                        <span class="h-2 w-2 rounded-full bg-success-500 shadow-sm shadow-success-500/50"></span>
                    @endif
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500 uppercase tracking-tighter">Tanggal Pesanan</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $purchaseOrder->po_date->format('d F Y') }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500 uppercase tracking-tighter">Estimasi Tiba</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('d F Y') : '-' }}</span>
                    </div>
                    
                    @if($purchaseOrder->status === 'received' && $purchaseOrder->received_at)
                    <div class="p-3 rounded-xl bg-success-50 dark:bg-success-500/5 border border-success-100 dark:border-success-500/10">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-success-600 dark:text-success-400 uppercase tracking-widest font-bold mb-1">Status: Barang Diterima</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $purchaseOrder->received_at->format('d F Y') }}</span>
                            <span class="text-[10px] text-gray-400 mt-0.5">{{ $purchaseOrder->received_at->format('H:i') }} WIB</span>
                        </div>
                    </div>
                    @endif

                    @if(in_array(auth()->user()->role, ['admin', 'warehouse']))
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-col gap-3">
                            <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Warehouse Notes:</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed bg-gray-50 dark:bg-white/5 p-3 rounded-lg border border-dashed border-gray-200 dark:border-gray-700">
                                Pastikan jumlah koli barang sesuai dengan faktur supplier sebelum konfirmasi terima.
                            </div>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="relative h-8 w-8 overflow-hidden rounded-full border border-gray-100 dark:border-gray-800 shadow-sm">
                                @if($purchaseOrder->creator->avatar)
                                    <img src="{{ asset('storage/' . $purchaseOrder->creator->avatar) }}" alt="{{ $purchaseOrder->creator->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 font-bold text-[10px]">
                                        {{ substr($purchaseOrder->creator->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 uppercase tracking-tighter">Dibuat oleh</span>
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $purchaseOrder->creator->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
