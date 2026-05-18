@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Produk</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><span class="font-medium text-gray-600 dark:text-gray-400">Katalog /</span></li>
                <li class="font-medium text-brand-500">Produk</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="text-brand-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Produk</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-error-50 dark:bg-error-500/10">
                    <svg class="text-error-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stok Rendah</p>
                    <h4 class="text-2xl font-bold text-error-600 dark:text-error-400">{{ $stats['low_stock'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="text-success-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nilai Inventori</p>
                    <h4 class="text-xl font-bold text-success-600 dark:text-success-400">Rp {{ number_format($stats['inventory_value'], 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable Card -->
    <!-- Main Content Card (Filter + Table) -->
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
                    <input type="text" placeholder="Cari SKU atau nama produk..." x-model.debounce.500ms="search"
                        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                </div>
                
                <!-- Category Filter -->
                <div class="relative" x-data="{ filter: '{{ request('category') }}' }" x-init="$watch('filter', value => {
                    const url = new URL(window.location.href);
                    if (value) { url.searchParams.set('category', value); } else { url.searchParams.delete('category'); }
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                })">
                    <select x-model="filter" class="appearance-none rounded-xl border border-gray-200 bg-white py-2.5 pl-5 pr-10 text-sm font-medium text-gray-700 outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white cursor-pointer">
                        <option value="" class="dark:bg-gray-900">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" class="dark:bg-gray-900">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </span>
                </div>
            </div>

            <!-- Create Button -->
            @if(auth()->user()->role !== 'admin')
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-bold text-white hover:bg-brand-600 transition shadow-theme-md active:scale-95">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Produk
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
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Produk
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'name' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'name' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Harga Beli</th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Harga Jual</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Stok
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'stock' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'stock' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        @if(auth()->user()->role !== 'admin')
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-lg object-cover border border-gray-100 dark:border-gray-700">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                                        <svg class="text-gray-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-[10px] font-bold text-brand-500 dark:text-brand-400 uppercase tracking-wider">{{ $product->sku }}</span>
                                    <h5 class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $product->name }}</h5>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">{{ $product->category->name }}</span>
                        </td>
                        <td class="px-5 py-4 text-end text-sm text-gray-600 dark:text-gray-400">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-end text-sm font-semibold text-gray-800 dark:text-white/90">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium {{ $product->stock <= $product->min_stock ? 'text-error-600 dark:text-error-400' : 'text-gray-800 dark:text-white/90' }}">
                                    {{ $product->stock }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $product->unit }}</span>
                                @if($product->stock <= $product->min_stock)
                                    <div class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-error-500"></span></div>
                                @endif
                            </div>
                        </td>
                        @if(auth()->user()->role !== 'admin')
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Edit">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M12.75 3L15 5.25M14.25 1.5L16.5 3.75L6.75 13.5H4.5V11.25L14.25 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                <form x-ref="deleteForm{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" @click="$dispatch('confirm', { title: 'Hapus Produk?', message: 'Tindakan ini tidak dapat dibatalkan. Hapus {{ $product->name }}?', confirmText: 'Ya, Hapus', cancelText: 'Batal', type: 'danger', onConfirm: () => $refs.deleteForm{{ $product->id }}.submit() })"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-error-500 hover:bg-error-50 transition dark:border-gray-800 dark:bg-transparent dark:hover:bg-error-500/10" title="Hapus">
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M14.25 4.5V15C14.25 15.4142 13.9142 15.75 13.5 15.75H4.5C4.08579 15.75 3.75 15.4142 3.75 15V4.5M2.25 4.5H15.75M7.5 7.5V12.75M10.5 7.5V12.75M6.75 2.25H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 7 }}" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="mb-4 text-gray-300 dark:text-gray-600" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada produk</p>
                                <p class="mt-1 text-xs text-gray-400">Klik "Tambah Produk" untuk mendaftarkan produk baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800">
            {{ $products->links() }}
        </div>
    </div>
@endsection
