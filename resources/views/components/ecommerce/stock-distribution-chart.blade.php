@props(['data' => []])

<div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Stock Distribution</h3>
            <p class="text-xs font-medium text-gray-500">Distribusi stok berdasarkan kategori produk.</p>
        </div>
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-50 text-gray-400 dark:bg-gray-900">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
        </div>
    </div>

    <div class="mb-6 flex justify-center">
        <div id="stockPieChart" 
            data-labels='@json(array_column($data, 'label'))'
            data-values='@json(array_column($data, 'value'))'
            class="min-h-[300px]"></div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        @foreach($data as $item)
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-gray-800">
                <div class="h-2 w-2 rounded-full" style="background-color: var(--chart-color-{{ $loop->index }})"></div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-gray-400 uppercase truncate">{{ $item['label'] }}</span>
                    <span class="text-xs font-black text-gray-900 dark:text-white">{{ number_format($item['value']) }} Units</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    :root {
        --chart-color-0: #465FFF;
        --chart-color-1: #9CB9FF;
        --chart-color-2: #31C48D;
        --chart-color-3: #F98080;
        --chart-color-4: #FACA15;
        --chart-color-5: #9061F9;
    }
</style>
