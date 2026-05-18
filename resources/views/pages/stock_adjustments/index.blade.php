@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Penyesuaian Stok</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="#">Manajemen Gudang /</a></li>
                <li class="font-medium text-brand-500">Penyesuaian</li>
            </ol>
        </nav>
    </div>

    <!-- Main Content Card (Filter + Table) -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header Controls (Global Search & Actions) -->
        <div class="flex flex-col gap-4 px-5 py-5 sm:px-6 sm:py-6 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-wrap gap-3 items-center">
                <!-- Search Input -->
                <div class="relative w-full sm:w-80" x-data="{ search: '{{ request('product_search') ?: request('search') }}' }" x-init="$watch('search', value => {
                    const url = new URL(window.location.href);
                    if (value) { url.searchParams.set('product_search', value); } else { url.searchParams.delete('product_search'); }
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                })">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </span>
                    <input type="text" placeholder="Cari No. Ref atau Produk..." x-model.debounce.500ms="search"
                        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                </div>
                
                <!-- Type Filter -->
                <div class="relative" x-data="{ type: '{{ request('type') }}' }" x-init="$watch('type', value => {
                    const url = new URL(window.location.href);
                    if (value) { url.searchParams.set('type', value); } else { url.searchParams.delete('type'); }
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                })">
                    <select x-model="type" class="appearance-none rounded-xl border border-gray-200 bg-white py-2.5 pl-5 pr-10 text-sm font-medium text-gray-700 outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white cursor-pointer min-w-[150px]">
                        <option value="">Semua Tipe</option>
                        <option value="addition">Penambahan</option>
                        <option value="subtraction">Pengurangan</option>
                    </select>
                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </span>
                </div>

                @if(request()->anyFilled(['product_search', 'ref_search', 'type', 'search']))
                    <a href="{{ route('stock-adjustments.index') }}" class="text-sm font-bold text-error-500 hover:text-error-600 transition">Reset Filter</a>
                @endif
            </div>

            <!-- Create Button -->
            <a href="{{ route('stock-adjustments.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-bold text-white hover:bg-brand-600 transition shadow-theme-md active:scale-95">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Baru
            </a>
        </div>

        <!-- Table -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-y border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/20">
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-12">No</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'adjustment_number', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5 group">
                                No. Ref
                                <div class="flex flex-col">
                                    <svg class="{{ request('sort') == 'adjustment_number' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg>
                                    <svg class="{{ request('sort') == 'adjustment_number' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg>
                                </div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Produk</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'type', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5 group">
                                Tipe
                                <div class="flex flex-col">
                                    <svg class="{{ request('sort') == 'type' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg>
                                    <svg class="{{ request('sort') == 'type' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg>
                                </div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'quantity', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center justify-center gap-1.5 group">
                                Qty
                                <div class="flex flex-col">
                                    <svg class="{{ request('sort') == 'quantity' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg>
                                    <svg class="{{ request('sort') == 'quantity' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg>
                                </div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Alasan</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Petugas</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'adjustment_date', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5 group">
                                Tanggal
                                <div class="flex flex-col">
                                    <svg class="{{ request('sort') == 'adjustment_date' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg>
                                    <svg class="{{ request('sort') == 'adjustment_date' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg>
                                </div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400 w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($adjustments as $adj)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ ($adjustments->currentPage() - 1) * $adjustments->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-4 font-mono text-xs font-bold text-gray-900 dark:text-white uppercase tracking-tighter">
                            {{ $adj->adjustment_number }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-brand-500 dark:text-brand-400 uppercase tracking-wider leading-none mb-1">{{ $adj->product->sku }}</span>
                                <h5 class="text-sm font-semibold text-gray-800 dark:text-white/90 leading-none">{{ $adj->product->name }}</h5>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($adj->type === 'addition')
                                <span class="inline-flex rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-600 dark:bg-success-500/10 dark:text-success-400">
                                    Penambahan
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-error-50 px-2.5 py-0.5 text-xs font-medium text-error-600 dark:bg-error-500/10 dark:text-error-400">
                                    Pengurangan
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-sm font-medium {{ $adj->type === 'subtraction' ? 'text-error-600 dark:text-error-400' : 'text-gray-800 dark:text-white/90' }}">
                                {{ $adj->type === 'subtraction' ? '-' : '+' }}{{ $adj->quantity }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                {{ str_replace('_', ' ', $adj->reason) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $adj->creator->name }}</span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $adj->adjustment_date->format('d M Y, H:i') }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end">
                                <a href="{{ route('stock-adjustments.show', $adj->id) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-4">
                                    <i data-lucide="clipboard-list" class="w-8 h-8 text-gray-300"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada riwayat penyesuaian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800">
            {{ $adjustments->links() }}
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endpush
