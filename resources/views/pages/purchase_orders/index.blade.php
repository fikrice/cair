@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Purchase Orders</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><span class="font-medium text-gray-600 dark:text-gray-400">Pembelian /</span></li>
                <li class="font-medium text-brand-500">PO</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="text-brand-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total PO</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10">
                    <svg class="text-warning-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
                    <h4 class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $stats['pending'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="text-success-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Received</p>
                    <h4 class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $stats['received'] }}</h4>
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

    <!-- DataTable Card -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-4 px-5 py-5 sm:px-6 sm:py-6 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <!-- Search Input -->
                <div class="relative w-full sm:w-80"
                    x-data="{ search: '{{ request('search') }}' }"
                    x-init="$watch('search', value => {
                        const url = new URL(window.location.href);
                        if (value) { url.searchParams.set('search', value); url.searchParams.set('page', 1); }
                        else { url.searchParams.delete('search'); }
                        window.location.href = url.toString();
                    })">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </span>
                    <input type="text" placeholder="Cari No. PO atau Supplier..." x-model.debounce.500ms="search"
                        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                </div>
                
                <!-- Status Filter -->
                <div class="relative z-20" x-data="{ filter: '{{ request('status') }}' }" x-init="$watch('filter', value => {
                    const url = new URL(window.location.href);
                    if (value) { url.searchParams.set('status', value); } else { url.searchParams.delete('status'); }
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                })">
                    <select x-model="filter" class="appearance-none rounded-xl border border-gray-200 bg-white py-2.5 pl-5 pr-10 text-sm font-medium text-gray-700 outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white cursor-pointer">
                        <option value="" class="dark:bg-gray-900">Semua Status</option>
                        <option value="draft" class="dark:bg-gray-900">Draft</option>
                        <option value="pending" class="dark:bg-gray-900">Pending</option>
                        <option value="received" class="dark:bg-gray-900">Received</option>
                        <option value="cancelled" class="dark:bg-gray-900">Cancelled</option>
                    </select>
                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </span>
                </div>
            </div>

            <!-- Create Button -->
            @if(in_array(auth()->user()->role, ['admin', 'purchasing']))
            <a href="{{ route('purchase-orders.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-bold text-white hover:bg-brand-600 transition shadow-theme-md active:scale-95">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat PO Baru
            </a>
            @endif
        </div>

        <!-- Table -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-y border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-12">No</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'po_date', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Tanggal
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'po_date' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'po_date' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'po_number', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                No. PO
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'po_number' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'po_number' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'supplier_id', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Supplier
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'supplier_id' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'supplier_id' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
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
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Pembayaran</th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($purchaseOrders as $po)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ ($purchaseOrders->currentPage() - 1) * $purchaseOrders->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-800 dark:text-white">{{ $po->po_date->format('d M Y') }}</span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $po->po_date->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="h-2 w-2 rounded-full {{ $po->status === 'received' ? 'bg-success-500' : ($po->status === 'pending' ? 'bg-warning-500' : 'bg-gray-400') }}"></div>
                                <span class="font-mono text-sm font-bold text-gray-900 dark:text-white">{{ $po->po_number }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 font-bold text-xs">
                                    {{ substr($po->supplier->name, 0, 2) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $po->supplier->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-end">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-4">
                            @switch($po->status)
                                @case('draft')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Draft
                                    </span>
                                    @break
                                @case('pending')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-50 px-2.5 py-0.5 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-warning-500 animate-pulse"></span> Pending
                                    </span>
                                    @break
                                @case('received')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> Received
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
                            @switch($po->payment_status)
                                @case('unpaid')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-error-50 px-3 py-1 text-[10px] font-bold text-error-600 uppercase tracking-widest dark:bg-error-500/10 dark:text-error-400">Belum Bayar</span>
                                    @break
                                @case('partial')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-50 px-3 py-1 text-[10px] font-bold text-warning-600 uppercase tracking-widest dark:bg-warning-500/10 dark:text-warning-400">Partial</span>
                                    @break
                                @case('paid')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-[10px] font-bold text-blue-600 uppercase tracking-widest dark:bg-blue-500/10 dark:text-blue-400">Lunas</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('purchase-orders.show', $po) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Lihat Detail">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>

                                {{-- AKSI BAYAR (FINANCE) --}}
                                @if($po->status === 'received' && $po->payment_status !== 'paid' && in_array(auth()->user()->role, ['admin', 'finance']))
                                    <a href="{{ route('purchase-orders.payment', $po) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-error-100 bg-error-50 text-error-600 hover:bg-error-100 transition dark:bg-error-500/10 dark:border-error-500/20" title="Bayar Tagihan">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22M17 19H9.5a3.5 3.5 0 0 1 0-7h5a3.5 3.5 0 0 0 0-7H6"/></svg>
                                    </a>
                                @endif

                                {{-- AKSI TERIMA (WAREHOUSE) --}}
                                @if($po->status === 'pending' && in_array(auth()->user()->role, ['admin', 'warehouse']))
                                    <form action="{{ route('purchase-orders.receive', $po) }}" method="POST" class="inline" x-ref="receiveForm{{ $po->id }}">
                                        @csrf
                                        <button type="button" @click="$dispatch('confirm', { title: 'Terima Barang?', message: 'Stok akan ditambahkan otomatis untuk PO {{ $po->po_number }}.', confirmText: 'Ya, Terima', type: 'success', onConfirm: () => $refs.receiveForm{{ $po->id }}.submit() })"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-success-100 bg-success-50 text-success-600 hover:bg-success-100 transition dark:bg-success-500/10 dark:border-success-500/20" title="Konfirmasi Terima Barang">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </button>
                                    </form>
                                @endif

                                {{-- AKSI EDIT/HAPUS (PURCHASING) --}}
                                @if($po->status === 'draft' && in_array(auth()->user()->role, ['admin', 'purchasing']))
                                <a href="{{ route('purchase-orders.edit', $po) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Edit Draft">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M12.75 3L15 5.25M14.25 1.5L16.5 3.75L6.75 13.5H4.5V11.25L14.25 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                <form action="{{ route('purchase-orders.destroy', $po) }}" method="POST" class="inline" x-ref="deleteForm{{ $po->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" @click="$dispatch('confirm', { title: 'Hapus PO?', message: 'Apakah Anda yakin ingin menghapus draft PO {{ $po->po_number }}?', confirmText: 'Ya, Hapus', type: 'danger', onConfirm: () => $refs.deleteForm{{ $po->id }}.submit() })"
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
                        <td colspan="6" class="px-5 py-16 text-center text-gray-500">Belum ada data PO.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800">
            {{ $purchaseOrders->links() }}
        </div>
    </div>
@endsection
