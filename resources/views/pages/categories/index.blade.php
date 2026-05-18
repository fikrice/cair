@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Manajemen Kategori</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><span class="font-medium text-gray-600 dark:text-gray-400">Katalog /</span></li>
                <li class="font-medium text-brand-500">Kategori</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="text-brand-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Kategori</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="text-success-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Memiliki Produk</p>
                    <h4 class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $stats['with_products'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10">
                    <svg class="text-warning-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tanpa Produk</p>
                    <h4 class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $stats['empty'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-6 xl:flex-row">
        <!-- Left: Table -->
        <div class="w-full @if(auth()->user()->role !== 'admin') xl:w-2/3 @endif">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <!-- Header -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:px-6 sm:py-6 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-800">
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
                        <input type="text" placeholder="Cari nama kategori..." x-model.debounce.500ms="search"
                            class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $categories->total() }} kategori ditemukan</span>
                </div>

                <!-- Table -->
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-y border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-12">No</th>
                                <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                        Nama Kategori
                                        <div class="flex flex-col"><svg class="{{ request('sort') == 'name' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'name' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                                    </a>
                                </th>
                                <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'products_count', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                        Produk
                                        <div class="flex flex-col"><svg class="{{ request('sort') == 'products_count' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'products_count' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                                    </a>
                                </th>
                                <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                        Dibuat
                                        <div class="flex flex-col"><svg class="{{ request('sort') == 'created_at' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'created_at' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                                    </a>
                                </th>
                                @if(auth()->user()->role !== 'admin')
                                <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($categories as $category)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-5 py-4">
                                    <h5 class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $category->name }}</h5>
                                    <p class="text-xs text-gray-400 mt-0.5 font-mono">{{ $category->slug }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $category->products_count > 0 ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                        {{ $category->products_count }} produk
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $category->created_at->format('d M Y') }}</td>
                                @if(auth()->user()->role !== 'admin')
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Edit">
                                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M12.75 3L15 5.25M14.25 1.5L16.5 3.75L6.75 13.5H4.5V11.25L14.25 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                        <form x-ref="deleteForm{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" @click="$dispatch('confirm', { title: 'Hapus Kategori?', message: 'Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?', confirmText: 'Ya, Hapus', cancelText: 'Batal', type: 'danger', onConfirm: () => $refs.deleteForm{{ $category->id }}.submit() })"
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
                                <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 5 }}" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="mb-4 text-gray-300 dark:text-gray-600" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada kategori</p>
                                        <p class="mt-1 text-xs text-gray-400">Tambahkan kategori pertama di panel sebelah kanan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>

        <!-- Right: Add Form (1/3) -->
        @if(auth()->user()->role !== 'admin')
        <div class="w-full xl:w-1/3">
            <div class="sticky top-24 rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Kategori Baru</h3>
                    <p class="mt-0.5 text-sm text-gray-500">Definisikan kategori untuk produk.</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Kategori <span class="text-error-500">*</span>
                                </label>
                                <input type="text" name="name" placeholder="Contoh: Serum Wajah" required value="{{ old('name') }}"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @error('name') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-bold text-white transition hover:bg-brand-600 shadow-theme-xs">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 4.16666V15.8333M4.16666 10H15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
