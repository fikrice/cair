@extends('layouts.app')

@section('content')
  <!-- Main Dashboard Container -->
  <div class="w-full space-y-6">
      
      <!-- Header Executive -->
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
          <div>
              <h1 class="text-xl font-semibold text-gray-900 dark:text-white uppercase tracking-[3px]">Dashboard Supervisor</h1>
              <p class="text-xs text-gray-500 font-medium italic">Pemantauan data katalog produk dan kondisi stok secara real-time.</p>
          </div>
          <div class="flex items-center gap-3">
              <div class="hidden sm:flex h-10 px-4 rounded-xl bg-white border border-gray-100 items-center justify-center shadow-sm dark:bg-white/5 dark:border-gray-800">
                  <span class="text-[10px] font-black text-brand-600 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</span>
              </div>
          </div>
      </div>

      <!-- Seksi 1: KPI Global (Metric Cards) -->
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
          @php
              $cards = [
                  [
                      'label' => 'Total Produk', 
                      'value' => number_format($stats['totalProducts']), 
                      'unit' => 'Varian Terdaftar',
                      'color' => 'brand', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>'
                  ],
                  [
                      'label' => 'Total Kategori', 
                      'value' => number_format($stats['totalCategories']), 
                      'unit' => 'Kategori Produk',
                      'color' => 'success', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>'
                  ],
                  [
                      'label' => 'Volume Stok', 
                      'value' => number_format($stats['totalStock']), 
                      'unit' => 'Unit Tersedia',
                      'color' => 'brand', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>'
                  ],
                  [
                      'label' => 'Stok Rendah', 
                      'value' => number_format($stats['lowStockCount']), 
                      'unit' => 'Varian Kritis',
                      'color' => 'error', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
                  ],
              ];
          @endphp

          @foreach($cards as $card)
          <div class="group relative rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
              <div class="flex items-center justify-between relative z-10">
                  <div class="min-w-0 flex-1">
                      <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-{{ $card['color'] }}-500 transition-colors">{{ $card['label'] }}</p>
                      <h4 class="mt-1 text-lg font-bold text-gray-900 dark:text-white truncate">{{ $card['value'] }}</h4>
                      <p class="text-[9px] font-medium text-gray-400 mt-0.5 uppercase tracking-tighter italic">{{ $card['unit'] }}</p>
                  </div>
                  <div class="shrink-0 flex h-10 w-10 items-center justify-center rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 transition-transform group-hover:scale-110 dark:bg-{{ $card['color'] }}-500/10">
                      {!! $card['icon'] !!}
                  </div>
              </div>
          </div>
          @endforeach
      </div>

      <!-- Seksi 2: Visualisasi Strategis & Kondisi Stok -->
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
          <!-- Stock Composition (Donut Chart) -->
          <div class="lg:col-span-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
              <h3 class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-6">Komposisi Stok Per Kategori</h3>
              <div id="stockDonut" class="w-full min-h-[300px] flex items-center justify-center"></div>
          </div>

          <!-- Peringatan Reorder (Stok Rendah) -->
          <div class="lg:col-span-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
              <h3 class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-6">Peringatan Stok Rendah / Kritis</h3>
              <div class="space-y-3">
                  @forelse($lowStockProducts as $prod)
                  <div class="flex items-center gap-3 rounded-lg border border-gray-50 p-4 dark:border-gray-800 bg-error-50/5 hover:bg-error-50 transition-colors">
                      <div class="min-w-0 flex-1">
                          <p class="truncate text-xs font-bold text-gray-900 dark:text-white uppercase">{{ $prod->name }}</p>
                          <p class="text-[10px] font-bold text-error-600 uppercase">Sisa Stok: {{ $prod->stock }} {{ $prod->unit }} (Min: {{ $prod->min_stock }})</p>
                      </div>
                      <div class="h-2 w-2 rounded-full bg-error-500 animate-pulse"></div>
                  </div>
                  @empty
                  <p class="text-center text-xs text-gray-400 italic py-12">Inventori aman. Tidak ada produk di bawah batas minimum stok.</p>
                  @endforelse
              </div>
          </div>
      </div>

      <!-- Seksi 3: Produk Terbaru Terdaftar -->
      <div class="rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="flex items-center justify-between border-b border-gray-50 px-6 py-4 dark:border-gray-800 bg-gray-50/10">
              <h3 class="text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-widest">Produk Terbaru Terdaftar</h3>
              <a href="{{ route('products.index') }}" class="text-[9px] font-bold text-brand-600 hover:underline uppercase">Lihat Semua Katalog</a>
          </div>
          <div class="overflow-x-auto w-full">
              <table class="w-full text-left text-xs min-w-[500px]">
                  <thead class="bg-gray-50/50 dark:bg-white/[0.02]">
                      <tr>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">SKU</th>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Nama Produk</th>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Kategori</th>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Harga Jual</th>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Stok Saat Ini</th>
                      </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                      @forelse($recentProducts as $prod)
                      <tr class="hover:bg-gray-50/30 transition-colors">
                          <td class="px-6 py-4 font-mono font-bold text-gray-900 dark:text-white text-[10px]">{{ $prod->sku }}</td>
                          <td class="px-6 py-4 text-gray-600 dark:text-gray-400 uppercase font-medium">{{ $prod->name }}</td>
                          <td class="px-6 py-4">
                              <span class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-[8px] font-black text-gray-700 dark:bg-gray-800 dark:text-gray-400 uppercase">
                                  {{ $prod->category->name }}
                              </span>
                          </td>
                          <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">Rp{{ number_format($prod->selling_price, 0, ',', '.') }}</td>
                          <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                              <span class="font-bold {{ $prod->stock <= $prod->min_stock ? 'text-error-600' : 'text-gray-900 dark:text-white' }}">
                                  {{ $prod->stock }} {{ $prod->unit }}
                              </span>
                          </td>
                      </tr>
                      @empty
                      <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data produk.</td></tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const commonOptions = {
              chart: { toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
              dataLabels: { enabled: false },
              grid: { borderColor: '#f9fafb', strokeDashArray: 4 }
          };

          // Stock Donut Chart
          new ApexCharts(document.querySelector("#stockDonut"), {
              ...commonOptions,
              series: @json(collect($pieChartData)->pluck('value')),
              labels: @json(collect($pieChartData)->pluck('label')),
              chart: { ...commonOptions.chart, type: 'donut', height: 300 },
              colors: ['#3C50E0', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
              legend: { position: 'bottom', fontSize: '10px' },
              plotOptions: { pie: { donut: { size: '75%', labels: { show: true, total: { show: true, label: 'Unit Total', fontSize: '10px', fontWeight: 600, formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0) } } } } }
          }).render();
      });
  </script>
@endsection
