@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Data Supplier</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><span class="font-medium text-gray-600 dark:text-gray-400">Pembelian /</span></li>
                <li class="font-medium text-brand-500">Supplier</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="text-brand-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Supplier</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="text-success-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Aktif</p>
                    <h4 class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $stats['active'] }}</h4>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10">
                    <svg class="text-warning-500" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nonaktif</p>
                    <h4 class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $stats['inactive'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable Card -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header: Search, Filter, Add Button -->
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
                    <input type="text" placeholder="Cari nama supplier..." x-model.debounce.500ms="search"
                        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                </div>
                
                <!-- Status Filter -->
                <div class="relative" x-data="{ filter: '{{ request('status') }}' }" x-init="$watch('filter', value => {
                    const url = new URL(window.location.href);
                    if (value) { url.searchParams.set('status', value); } else { url.searchParams.delete('status'); }
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                })">
                    <select x-model="filter" class="appearance-none rounded-xl border border-gray-200 bg-white py-2.5 pl-5 pr-10 text-sm font-medium text-gray-700 outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white cursor-pointer">
                        <option value="" class="dark:bg-gray-900">Semua Status</option>
                        <option value="active" class="dark:bg-gray-900">Aktif</option>
                        <option value="inactive" class="dark:bg-gray-900">Nonaktif</option>
                    </select>
                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </span>
                </div>
            </div>

            <!-- Create Button -->
            <a href="{{ route('suppliers.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-bold text-white hover:bg-brand-600 transition shadow-theme-md active:scale-95">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Supplier
            </a>
        </div>

        <!-- Table -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-y border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">No</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'code', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Kode
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'code' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'code' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Nama Supplier
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'name' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'name' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Kontak</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'city', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5">
                                Kota
                                <div class="flex flex-col"><svg class="{{ request('sort') == 'city' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg><svg class="{{ request('sort') == 'city' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-400' }}" width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg></div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ ($suppliers->currentPage() - 1) * $suppliers->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-md bg-brand-50 px-2 py-1 text-xs font-bold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 tracking-wider">{{ $supplier->code }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div>
                                <h5 class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $supplier->name }}</h5>
                                @if($supplier->contact_person)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $supplier->contact_person }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="space-y-1">
                                @if($supplier->phone)
                                <div class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    {{ $supplier->phone }}
                                </div>
                                @endif
                                @if($supplier->email)
                                <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-500">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    {{ $supplier->email }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $supplier->city ?? '-' }}</td>
                        <td class="px-5 py-4">
                            @if($supplier->status === 'active')
                                <span class="inline-flex items-center gap-1 rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('suppliers.toggle-status', $supplier) }}" method="POST" class="inline" x-ref="toggleForm{{ $supplier->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button" @click="$dispatch('confirm', { title: '{{ $supplier->status === "active" ? "Nonaktifkan" : "Aktifkan" }} Supplier?', message: 'Supplier {{ $supplier->name }} akan di{{ $supplier->status === "active" ? "nonaktifkan" : "aktifkan" }}.', confirmText: 'Ya, Lanjutkan', cancelText: 'Batal', type: '{{ $supplier->status === "active" ? "warning" : "success" }}', onConfirm: () => $refs.toggleForm{{ $supplier->id }}.submit() })"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border transition {{ $supplier->status === 'active' ? 'border-warning-200 bg-warning-50 text-warning-500 hover:bg-warning-100 dark:border-warning-500/20 dark:bg-warning-500/10 dark:hover:bg-warning-500/20' : 'border-success-200 bg-success-50 text-success-500 hover:bg-success-100 dark:border-success-500/20 dark:bg-success-500/10 dark:hover:bg-success-500/20' }}" title="{{ $supplier->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                                    </button>
                                </form>
                                <a href="{{ route('suppliers.show', $supplier) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Lihat Detail">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Edit">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M12.75 3L15 5.25M14.25 1.5L16.5 3.75L6.75 13.5H4.5V11.25L14.25 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                <form x-ref="deleteForm{{ $supplier->id }}" action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" @click="$dispatch('confirm', { title: 'Hapus Supplier?', message: 'Apakah Anda yakin ingin menghapus supplier {{ $supplier->name }}?', confirmText: 'Ya, Hapus', cancelText: 'Batal', type: 'danger', onConfirm: () => $refs.deleteForm{{ $supplier->id }}.submit() })"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-error-500 hover:bg-error-50 transition dark:border-gray-800 dark:bg-transparent dark:hover:bg-error-500/10" title="Hapus">
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M14.25 4.5V15C14.25 15.4142 13.9142 15.75 13.5 15.75H4.5C4.08579 15.75 3.75 15.4142 3.75 15V4.5M2.25 4.5H15.75M7.5 7.5V12.75M10.5 7.5V12.75M6.75 2.25H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="mb-4 text-gray-300 dark:text-gray-600" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada data supplier</p>
                                <p class="mt-1 text-xs text-gray-400">Klik "Tambah Supplier" untuk menambahkan data baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800">
            {{ $suppliers->links() }}
        </div>
    </div>
@endsection
