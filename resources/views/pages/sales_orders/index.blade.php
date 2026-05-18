@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Sales Order (SO)</h2>
            <p class="text-sm text-gray-500">Kelola pesanan pelanggan dan penjualan.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="text-brand-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total SO</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="text-success-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Selesai</p>
                    <h4 class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $stats['completed'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10">
                    <svg class="text-warning-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Proses</p>
                    <h4 class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $stats['processing'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/5">
                    <svg class="text-gray-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Draft</p>
                    <h4 class="text-2xl font-bold text-gray-600 dark:text-gray-400">{{ $stats['draft'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card (Filter + Table) -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Filter & Search Header -->
        <div class="px-5 py-5 sm:px-6 sm:py-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <form action="{{ route('sales-orders.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-80">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. SO atau Pelanggan..." 
                            class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>

                    <!-- Status Filter -->
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()" 
                            class="appearance-none rounded-xl border border-gray-200 bg-white py-2.5 pl-5 pr-10 text-sm font-medium text-gray-700 outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-700 dark:bg-gray-800 dark:text-white cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Proses</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                        </span>
                    </div>

                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('sales-orders.index') }}" class="text-sm font-bold text-error-500 hover:text-error-600 transition ml-2">Reset</a>
                    @endif
                </form>

                <!-- Create Button -->
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('sales-orders.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-bold text-white hover:bg-brand-600 transition shadow-theme-md active:scale-95">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Buat SO Baru
                </a>
                @endif
            </div>
        </div>

        <!-- Table Area -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-y border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-12">No</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'so_date', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Tanggal
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'so_date' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'so_date' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'so_number', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                No. SO
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'so_number' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'so_number' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'customer_name', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Pelanggan
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'customer_name' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'customer_name' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'total_amount', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5 justify-end">
                                Total
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'total_amount' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'total_amount' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Status
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'status' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'status' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($salesOrders as $so)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ ($salesOrders->currentPage() - 1) * $salesOrders->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-800 dark:text-white">{{ $so->so_date->format('d M Y') }}</span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $so->so_date->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-2 rounded-full {{ $so->status === 'completed' ? 'bg-success-500' : ($so->status === 'processing' ? 'bg-warning-500' : 'bg-gray-400') }}"></div>
                                <span class="font-mono text-sm font-bold text-gray-900 dark:text-white">{{ $so->so_number }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 font-bold text-xs">
                                    {{ substr($so->customer_name, 0, 2) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $so->customer_name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-end">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($so->total_amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-4">
                            @switch($so->status)
                                @case('draft')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Draft
                                    </span>
                                    @break
                                @case('processing')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-50 px-2.5 py-0.5 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-warning-500 animate-pulse"></span> Processing
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> Completed
                                    </span>
                                    @break
                                @case('cancelled')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-error-50 px-2.5 py-0.5 text-xs font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-error-500"></span> Cancelled
                                    </span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('sales-orders.show', $so) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Lihat Detail">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>

                                @php
                                    $isStockConfirmed = $so->stockMovements->isNotEmpty();
                                @endphp

                                @if($so->status === 'draft' && auth()->user()->role !== 'warehouse')
                                    <a href="{{ route('sales-orders.edit', $so) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-warning-300 hover:text-warning-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-warning-500" title="Edit Pesanan">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                @endif

                                @if($so->status === 'processing')
                                    {{-- Aksi Gudang: Konfirmasi Stok (Hanya setelah lunas dibayar) --}}
                                    @if(!$isStockConfirmed && auth()->user()->role === 'warehouse' && $so->payment_status === 'paid')
                                        <form action="{{ route('sales-orders.complete', $so) }}" method="POST" class="inline" x-ref="completeForm{{ $so->id }}">
                                            @csrf
                                            <button type="button" @click="$dispatch('confirm', { title: 'Konfirmasi Stok?', message: 'Konfirmasi bahwa barang SO {{ $so->so_number }} siap kirim dan potong stok?', confirmText: 'Ya, Siapkan', type: 'warning', onConfirm: () => $refs.completeForm{{ $so->id }}.submit() })"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-warning-500 hover:bg-warning-50 transition dark:border-gray-800 dark:bg-transparent dark:hover:bg-warning-500/10" title="Siapkan Barang">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17 4 12"/></svg>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Aksi Finance: Proses Bayar (Sebelum barang disiapkan) --}}
                                    @if(in_array(auth()->user()->role, ['admin', 'finance']) && $so->payment_status !== 'paid')
                                        <a href="{{ route('sales-orders.payment', $so) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-brand-500 hover:bg-brand-50 transition dark:border-gray-800 dark:bg-transparent dark:hover:bg-brand-500/10" title="Proses Pembayaran">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                        </a>
                                    @endif
                                @endif

                                @if($so->status === 'draft' && auth()->user()->role === 'admin')
                                    <form action="{{ route('sales-orders.destroy', $so) }}" method="POST" class="inline" x-ref="deleteForm{{ $so->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" @click="$dispatch('confirm', { title: 'Hapus SO?', message: 'Apakah Anda yakin ingin menghapus draft SO {{ $so->so_number }}?', confirmText: 'Ya, Hapus', type: 'danger', onConfirm: () => $refs.deleteForm{{ $so->id }}.submit() })"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-error-500 hover:bg-error-50 transition dark:border-gray-800 dark:bg-transparent dark:hover:bg-error-500/10" title="Hapus">
                                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M14.25 4.5V15C14.25 15.4142 13.9142 15.75 13.5 15.75H4.5C4.08579 15.75 3.75 15.4142 3.75 15V4.5M2.25 4.5H15.75M7.5 7.5V12.75M10.5 7.5V12.75M6.75 2.25H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400">Tidak ada pesanan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-5 border-t border-gray-100 dark:border-gray-800">
            {{ $salesOrders->links() }}
        </div>
    </div>
@endsection
