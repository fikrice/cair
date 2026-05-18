@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Riwayat Pergerakan Stok</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li class="font-medium text-brand-500">Stock Movements</li>
            </ol>
        </nav>
    </div>

    <!-- Main Content Card (Filter + Table) -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header Controls -->
        <div class="flex flex-col gap-4 px-5 py-5 sm:px-6 sm:py-6 sm:flex-row sm:items-center border-b border-gray-100 dark:border-gray-800 justify-between">
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
                    <input type="text" placeholder="Cari Produk atau SKU..." x-model.debounce.500ms="search"
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
                        <option value="in">Masuk</option>
                        <option value="out">Keluar</option>
                        <option value="adjustment">Penyesuaian</option>
                    </select>
                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </span>
                </div>

                @if(request()->anyFilled(['product_search', 'ref_search', 'type', 'search']))
                    <a href="{{ route('stock-movements.index') }}" class="text-sm font-bold text-error-500 hover:text-error-600 transition">Reset Filter</a>
                @endif
            </div>
        </div>

        <!-- Table -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-y border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/20">
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-32">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1.5 group">
                                Waktu
                                <div class="flex flex-col">
                                    <svg class="{{ (request('sort', 'created_at') == 'created_at' && request('order', 'desc') == 'asc') ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg>
                                    <svg class="{{ (request('sort', 'created_at') == 'created_at' && request('order', 'desc') == 'desc') ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg>
                                </div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Produk</th>
                        <th class="px-5 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-400 w-32">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'type', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center justify-center gap-1.5 group">
                                Tipe
                                <div class="flex flex-col">
                                    <svg class="{{ request('sort') == 'type' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg>
                                    <svg class="{{ request('sort') == 'type' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg>
                                </div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400 w-32">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'quantity', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center justify-end gap-1.5 group">
                                Jumlah
                                <div class="flex flex-col">
                                    <svg class="{{ request('sort') == 'quantity' && request('order') == 'asc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 2L8 5H2L5 2Z" fill="currentColor"/></svg>
                                    <svg class="{{ request('sort') == 'quantity' && request('order') == 'desc' ? 'text-brand-500' : 'text-gray-300 dark:text-gray-600 group-hover:text-gray-400' }}" width="8" height="8" viewBox="0 0 10 10" fill="none"><path d="M5 8L2 5H8L5 8Z" fill="currentColor"/></svg>
                                </div>
                            </a>
                        </th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Referensi</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($movements as $movement)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-800 dark:text-white">{{ $movement->created_at->format('d M Y') }}</span>
                                <span class="text-[10px] uppercase tracking-tighter">{{ $movement->created_at->format('H:i:s') }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-brand-500 dark:text-brand-400 uppercase tracking-wider leading-none mb-1">{{ $movement->product->sku }}</span>
                                <h5 class="font-semibold text-gray-800 dark:text-white/90 leading-none">{{ $movement->product->name }}</h5>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($movement->type === 'in')
                                <span class="inline-flex rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-600 dark:bg-success-500/10 dark:text-success-400">
                                    Stok Masuk
                                </span>
                            @elseif($movement->type === 'out')
                                <span class="inline-flex rounded-full bg-error-50 px-2.5 py-0.5 text-xs font-medium text-error-600 dark:bg-error-500/10 dark:text-error-400">
                                    Stok Keluar
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-warning-50 px-2.5 py-0.5 text-xs font-medium text-warning-600 dark:bg-warning-500/10 dark:text-warning-400">
                                    Penyesuaian
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-end font-mono text-sm">
                            <span class="font-semibold {{ $movement->quantity >= 0 ? 'text-success-600' : 'text-error-600' }}">
                                {{ $movement->quantity >= 0 ? '+' : '' }}{{ number_format($movement->quantity, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $movement->reference ?: '-' }}</span>
                                <span class="text-[10px] text-gray-400 italic leading-none mt-1">{{ $movement->reason }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">
                            {{ $movement->user->name }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-gray-500 dark:text-gray-400 italic">
                            Belum ada riwayat pergerakan stok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800">
            {{ $movements->links() }}
        </div>
    </div>
@endsection
