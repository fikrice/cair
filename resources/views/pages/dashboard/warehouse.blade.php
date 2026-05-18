@extends('layouts.app')

@section('content')
  <!-- Header Utama Dashboard -->
  <div class="mb-6">
      <h1 class="text-xl font-semibold text-gray-900 dark:text-white uppercase tracking-tight">Pusat Kendali Gudang</h1>
      <p class="text-xs text-gray-500 font-medium italic">Data diperbarui secara real-time berdasarkan aktivitas logistik terakhir.</p>
  </div>

  <!-- Seksi 1: Ringkasan Performa (Stats) -->
  <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
      @php
          $cards = [
              ['label' => 'Stok Kritis', 'value' => $stats['lowStockCount'], 'unit' => 'SKU', 'color' => 'error', 'icon' => 'exclamation-triangle'],
              ['label' => 'Antrean Keluar', 'value' => $stats['pendingSO'], 'unit' => 'Order', 'color' => 'warning', 'icon' => 'truck'],
              ['label' => 'Antrean Masuk', 'value' => $stats['pendingPO'], 'unit' => 'PO', 'color' => 'success', 'icon' => 'download'],
              ['label' => 'Stok Tersedia', 'value' => number_format($stats['totalStock']), 'unit' => 'Unit', 'color' => 'brand', 'icon' => 'box'],
          ];
      @endphp

      @foreach($cards as $card)
      <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="min-w-0">
              <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 truncate">{{ $card['label'] }}</p>
              <h4 class="mt-0.5 text-lg font-bold text-gray-900 dark:text-white">
                  {{ $card['value'] }} <span class="text-[10px] font-normal text-gray-400">{{ $card['unit'] }}</span>
              </h4>
          </div>
          <div class="shrink-0 rounded-lg bg-{{ $card['color'] }}-50 p-1.5 text-{{ $card['color'] }}-600 dark:bg-{{ $card['color'] }}-500/10">
              @if($card['icon'] === 'exclamation-triangle')
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
              @elseif($card['icon'] === 'truck')
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/><path d="M19 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/><path d="M13 5H1v10h12V5z"/><path d="M13 15h7l3-4v-6h-10v10z"/></svg>
              @elseif($card['icon'] === 'download')
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              @else
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
              @endif
          </div>
      </div>
      @endforeach
  </div>

  <!-- Seksi 2: Visualisasi & Tren Inventori -->
  <div class="mb-4 px-1">
      <h2 class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-[2px]">Analisis & Tren Inventori</h2>
      <div class="h-1 w-12 bg-brand-500 mt-1 rounded-full"></div>
  </div>

  <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <!-- Grafik Pergerakan -->
      <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="flex items-center justify-between mb-4">
              <h3 class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pergerakan Barang (In/Out)</h3>
              <span class="text-[9px] font-medium text-gray-400 italic">7 Hari Terakhir</span>
          </div>
          <div id="movementChart" class="w-full min-h-[250px]"></div>
      </div>

      <!-- Grafik Komposisi -->
      <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="flex items-center justify-between mb-4">
              <h3 class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Distribusi Stok per Kategori</h3>
              <span class="text-[9px] font-medium text-gray-400 italic">Live Status</span>
          </div>
          <div id="categoryDonut" class="w-full min-h-[250px] flex items-center justify-center"></div>
      </div>
  </div>

  <!-- Seksi 3: Aktivitas Operasional -->
  <div class="mb-4 px-1">
      <h2 class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-[2px]">Tugas Operasional Hari Ini</h2>
      <div class="h-1 w-12 bg-warning-500 mt-1 rounded-full"></div>
  </div>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
      <!-- Tabel Antrean Picking -->
      <div class="lg:col-span-2 rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="flex items-center justify-between border-b border-gray-50 px-6 py-4 dark:border-gray-800 bg-gray-50/20">
              <h3 class="text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-widest">Antrean Picking & Pengemasan</h3>
              <a href="{{ route('sales-orders.index') }}" class="text-[9px] font-bold text-brand-600 hover:underline uppercase">Lihat Seluruhnya</a>
          </div>
          <div class="overflow-x-auto w-full">
              <table class="w-full text-left text-xs min-w-[500px]">
                  <thead class="bg-gray-50/50 dark:bg-white/[0.02]">
                      <tr>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Nomor Sales Order</th>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Nama Pelanggan</th>
                          <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px] text-center">Aksi</th>
                      </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                      @forelse($pendingShipments as $so)
                      <tr class="hover:bg-gray-50/30 transition-colors">
                          <td class="px-6 py-3 font-mono font-bold text-gray-900 dark:text-white italic">{{ $so->so_number }}</td>
                          <td class="px-6 py-3 text-gray-600 dark:text-gray-400 uppercase font-medium">{{ $so->customer_name }}</td>
                          <td class="px-6 py-3 text-center">
                              <a href="{{ route('sales-orders.show', $so) }}" class="inline-flex items-center rounded-md bg-brand-50 px-3 py-1 text-[9px] font-bold text-brand-700 dark:bg-brand-500/10 dark:text-brand-400 uppercase hover:bg-brand-500 hover:text-white transition ring-1 ring-inset ring-brand-500/20">Mulai Picking</a>
                          </td>
                      </tr>
                      @empty
                      <tr><td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">Semua pesanan sudah diproses dengan baik.</td></tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>

      <!-- Alerts (Stok Rendah) -->
      <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
          <h3 class="mb-4 text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-widest text-center">Peringatan Reorder</h3>
          <div class="space-y-2">
              @forelse($lowStockProducts as $prod)
              <div class="flex items-center gap-3 rounded-lg border border-gray-50 p-3 dark:border-gray-800 bg-error-50/5 hover:bg-error-50 transition-colors">
                  <div class="min-w-0 flex-1">
                      <p class="truncate text-[10px] font-bold text-gray-900 dark:text-white uppercase">{{ $prod->name }}</p>
                      <p class="text-[9px] font-bold text-error-600 uppercase">Sisa Stok: {{ $prod->stock }}</p>
                  </div>
                  <div class="h-2 w-2 rounded-full bg-error-500 shadow-sm animate-pulse"></div>
              </div>
              @empty
              <p class="text-center text-[10px] text-gray-400 italic py-6 italic">Tidak ada stok kritis.</p>
              @endforelse
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const commonOptions = {
              chart: { toolbar: { show: false }, fontFamily: 'Inter, sans-serif', width: '100%' },
              dataLabels: { enabled: false },
              stroke: { show: true, width: 2, colors: ['transparent'] },
              grid: { borderColor: '#f9fafb', strokeDashArray: 4 }
          };

          // Movement Chart
          new ApexCharts(document.querySelector("#movementChart"), {
              ...commonOptions,
              series: [{ name: 'Masuk', data: @json($movementChart['inbound']) }, { name: 'Keluar', data: @json($movementChart['outbound']) }],
              chart: { ...commonOptions.chart, type: 'bar', height: 250 },
              colors: ['#10B981', '#F59E0B'],
              plotOptions: { bar: { horizontal: false, columnWidth: '40%', borderRadius: 4 } },
              xaxis: { categories: @json($movementChart['labels']), axisBorder: { show: false }, axisTicks: { show: false } },
              legend: { position: 'top', horizontalAlign: 'right', fontSize: '10px' }
          }).render();

          // Donut Chart
          new ApexCharts(document.querySelector("#categoryDonut"), {
              ...commonOptions,
              series: @json(collect($pieChartData)->pluck('value')),
              labels: @json(collect($pieChartData)->pluck('label')),
              chart: { ...commonOptions.chart, type: 'donut', height: 280 },
              colors: ['#3C50E0', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
              legend: { position: 'bottom', fontSize: '10px' },
              plotOptions: { pie: { donut: { size: '70%', labels: { show: true, total: { show: true, label: 'Unit', fontSize: '10px', fontWeight: 600, formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0) } } } } }
          }).render();
      });
  </script>
@endsection
