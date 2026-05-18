@extends('layouts.app')

@section('content')
    <!-- Header & Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Buku Kas Utama</h2>
                <p class="text-xs text-gray-500 font-medium italic">Rekapitulasi seluruh arus dana masuk dan keluar (General Ledger).</p>
            </div>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                <li><a class="hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><span class="px-1">/</span></li>
                <li class="text-brand-500">Buku Kas</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        @php
            $kpiCards = [
                ['label' => 'Pemasukan All-Time', 'value' => 'Rp ' . number_format($stats['total_income'], 0, ',', '.'), 'color' => 'success', 'icon' => '<path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
                ['label' => 'Pengeluaran All-Time', 'value' => 'Rp ' . number_format($stats['total_expense'], 0, ',', '.'), 'color' => 'error', 'icon' => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>'],
                ['label' => 'Pemasukan Bulan Ini', 'value' => 'Rp ' . number_format($stats['this_month_income'], 0, ',', '.'), 'color' => 'success', 'icon' => '<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>'],
                ['label' => 'Pengeluaran Bulan Ini', 'value' => 'Rp ' . number_format($stats['this_month_expense'], 0, ',', '.'), 'color' => 'error', 'icon' => '<polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/>'],
            ];
        @endphp

        @foreach($kpiCards as $card)
        <div class="group relative rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md hover:border-{{ $card['color'] }}-200 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:border-{{ $card['color'] }}-500/30 overflow-hidden">
            <div class="flex items-center justify-between relative z-10">
                <div class="min-w-0 flex-1">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-{{ $card['color'] }}-500 transition-colors">{{ $card['label'] }}</p>
                    <h4 class="mt-1 text-lg font-bold text-gray-900 dark:text-white truncate">{{ $card['value'] }}</h4>
                </div>
                <div class="shrink-0 flex h-10 w-10 items-center justify-center rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 transition-transform group-hover:scale-110 group-hover:-rotate-3 dark:bg-{{ $card['color'] }}-500/10">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">{!! $card['icon'] !!}</svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Ledger Table Card -->
    <div class="rounded-2xl border border-gray-100 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        
        <!-- Toolbar Filters & Action -->
        <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between border-b border-gray-50 dark:border-gray-800 bg-gray-50/30 dark:bg-transparent">
            
            <form action="{{ route('transactions.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <!-- Search Box -->
                <div class="relative w-full sm:w-64">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Referensi..." 
                        class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-xs font-bold outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
                
                <!-- Filter Dropdown -->
                <div class="relative w-full sm:w-48">
                    <select name="method" onchange="this.form.submit()" class="appearance-none w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-4 pr-10 text-xs font-bold text-gray-700 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white cursor-pointer uppercase tracking-widest">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Tunai (Cash)</option>
                        <option value="transfer" {{ request('method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="e-wallet" {{ request('method') == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                    </select>
                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </span>
                </div>

                <!-- Reset Filter -->
                @if(request()->anyFilled(['search', 'method']))
                    <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-error-500 hover:text-error-600 transition uppercase tracking-widest w-full sm:w-auto text-center">Reset</a>
                @endif
            </form>

            <!-- Action Button -->
            <a href="{{ route('transactions.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-xs font-bold text-white uppercase tracking-widest hover:bg-brand-600 transition shadow-theme-md active:scale-95">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Transaksi
            </a>
        </div>

        <!-- Jurnal Table -->
        <div class="max-w-full overflow-x-auto scrollbar-hide">
            <table class="w-full border-collapse text-left min-w-[800px]">
                <thead class="bg-gray-50/80 dark:bg-white/[0.05]">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal / User</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Dokumen</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Mutasi Nominal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4 text-sm font-bold text-gray-500">
                            {{ str_pad(($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $trx->payment_date->format('d M Y') }}</span>
                                <span class="text-xs text-gray-500 uppercase tracking-tight mt-0.5"><span class="text-brand-500">@</span>{{ $trx->creator->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                @if($trx->sales_order_id)
                                    <a href="{{ route('sales-orders.show', $trx->sales_order_id) }}" class="text-sm font-mono font-bold text-brand-600 dark:text-brand-400 mb-0.5 hover:underline transition">
                                        {{ $trx->reference_number }}
                                    </a>
                                @elseif($trx->purchase_order_id)
                                    <a href="{{ route('purchase-orders.show', $trx->purchase_order_id) }}" class="text-sm font-mono font-bold text-error-600 dark:text-error-400 mb-0.5 hover:underline transition">
                                        {{ $trx->reference_number }}
                                    </a>
                                @else
                                    <span class="text-sm font-mono font-bold text-gray-500 mb-0.5">{{ $trx->reference_number ?? 'MANUAL-TRX' }}</span>
                                @endif
                                <span class="text-xs text-gray-500 italic truncate max-w-[200px]" title="{{ $trx->description }}">{{ $trx->description }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($trx->sales_order_id)
                                <div class="inline-flex items-center gap-2 rounded-md bg-success-50 px-2.5 py-1 text-xs font-bold text-success-700 uppercase tracking-widest dark:bg-success-500/10">
                                    <div class="h-1.5 w-1.5 rounded-full bg-success-500"></div> Penjualan
                                </div>
                            @elseif($trx->purchase_order_id)
                                <div class="inline-flex items-center gap-2 rounded-md bg-error-50 px-2.5 py-1 text-xs font-bold text-error-700 uppercase tracking-widest dark:bg-error-500/10">
                                    <div class="h-1.5 w-1.5 rounded-full bg-error-500"></div> Pembelian
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 rounded-md bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600 uppercase tracking-widest dark:bg-gray-800 dark:text-gray-400">
                                    <div class="h-1.5 w-1.5 rounded-full bg-gray-500"></div> Operasional
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center text-xs font-bold uppercase tracking-widest
                                {{ $trx->payment_method === 'cash' ? 'text-orange-600 dark:text-orange-400' : '' }}
                                {{ $trx->payment_method === 'transfer' ? 'text-blue-600 dark:text-blue-400' : '' }}
                                {{ $trx->payment_method === 'e-wallet' ? 'text-purple-600 dark:text-purple-400' : '' }}
                            ">
                                @if($trx->payment_method === 'cash')
                                    <svg class="mr-1.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="6" width="20" height="12" rx="2"/></svg>
                                @elseif($trx->payment_method === 'transfer')
                                    <svg class="mr-1.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11m16-11v11M8 14v3m4-3v3m4-3v3"/></svg>
                                @else
                                    <svg class="mr-1.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                                @endif
                                {{ $trx->payment_method }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-base font-black tracking-tight {{ $trx->type === 'income' ? 'text-success-600 dark:text-success-400' : 'text-error-600 dark:text-error-400' }}">
                                {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('transactions.destroy', $trx) }}" method="POST" class="inline" x-ref="deleteForm{{ $trx->id }}">
                                @csrf @method('DELETE')
                                <button type="button" @click="$dispatch('confirm', { title: 'Hapus Rekaman Transaksi?', message: 'Data ini akan dihapus dari buku kas. Jika ini terkait dengan SO/PO, status pembayarannya akan ikut terpengaruh.', confirmText: 'Ya, Hapus Data', type: 'danger', onConfirm: () => $refs.deleteForm{{ $trx->id }}.submit() })"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-transparent text-gray-400 hover:border-error-100 hover:bg-error-50 hover:text-error-500 transition-all dark:hover:border-error-500/20 dark:hover:bg-error-500/10">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-50 text-gray-400 dark:bg-gray-800">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Buku Kas Kosong</h3>
                                <p class="text-xs text-gray-500 mt-1">Belum ada riwayat transaksi finansial yang terekam.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-transparent">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
@endsection
