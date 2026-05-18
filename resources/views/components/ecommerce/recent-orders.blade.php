@props(['orders' => []])

<div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col gap-4 px-8 py-8 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.02]">
        <div>
            <h3 class="text-lg font-black text-gray-900 dark:text-white">Recent Transactions</h3>
            <p class="text-xs font-medium text-gray-500">Aktivitas penjualan terbaru yang masuk ke sistem.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('reports.sales') }}" class="inline-flex items-center gap-2 rounded-2xl border-2 border-gray-100 bg-white px-5 py-2.5 text-xs font-black text-gray-600 hover:bg-gray-50 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 uppercase tracking-widest">
                Full Logs
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-white dark:bg-transparent">
                    <th class="px-8 py-4 text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Order Ref</p>
                    </th>
                    <th class="px-8 py-4 text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Customer</p>
                    </th>
                    <th class="px-8 py-4 text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Status</p>
                    </th>
                    <th class="px-8 py-4 text-right">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Amount</p>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-brand-600 font-mono tracking-tighter">{{ $order->so_number }}</span>
                                <span class="text-[10px] font-bold text-gray-400">{{ $order->so_date->format('d M, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[10px] font-black text-gray-600 border border-gray-200 dark:border-gray-700">
                                    {{ substr($order->customer_name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $order->customer_name }}</span>
                                    <span class="text-[9px] font-bold text-gray-500 italic">Sales by {{ $order->creator->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            @if($order->status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-success-50 text-success-700 text-[10px] font-black dark:bg-success-500/10 dark:text-success-400 uppercase tracking-wider">
                                    Paid
                                </span>
                            @elseif($order->status === 'processing')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-[10px] font-black dark:bg-amber-500/10 dark:text-amber-400 uppercase tracking-wider">
                                    Processing
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-50 text-gray-700 text-[10px] font-black dark:bg-gray-800 dark:text-gray-400 uppercase tracking-wider">
                                    {{ $order->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right">
                            <p class="text-sm font-black text-gray-900 dark:text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <p class="text-sm font-bold text-gray-400 italic">Belum ada transaksi terekam.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>