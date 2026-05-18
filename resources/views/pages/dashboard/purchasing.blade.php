@extends('layouts.app')

@section('content')
  <!-- Main Dashboard Container -->
  <div class="w-full space-y-6">
      
      <!-- Header Dashboard -->
      <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
              <h1 class="text-xl font-semibold text-gray-900 dark:text-white uppercase tracking-tight">Pusat Kendali Pengadaan (Purchasing)</h1>
              <p class="text-xs text-gray-500 font-medium italic">Optimasi rantai pasok, manajemen vendor, dan kontrol belanja stok.</p>
          </div>
          <a href="{{ route('purchase-orders.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-[10px] font-bold text-white uppercase hover:bg-brand-600 transition shadow-sm active:scale-95">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Buat PO Baru
          </a>
      </div>

      <!-- Seksi 1: KPI Pengadaan -->
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
          @php
              $cards = [
                  [
                      'label' => 'Total Transaksi PO', 
                      'value' => \App\Models\PurchaseOrder::count() . ' PO', 
                      'unit' => 'Seluruh Waktu',
                      'color' => 'brand', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>'
                  ],
                  [
                      'label' => 'Menunggu Diterima', 
                      'value' => $stats['pendingPO'] . ' PO', 
                      'unit' => 'Proses Pengiriman',
                      'color' => 'warning', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/><path d="M19 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/><path d="M13 5H1v10h12V5z"/><path d="M13 15h7l3-4v-6h-10v10z"/></svg>'
                  ],
                  [
                      'label' => 'Stok Kritis', 
                      'value' => $stats['lowStockCount'] . ' SKU', 
                      'unit' => 'Perlu Reorder',
                      'color' => 'error', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
                  ],
                  [
                      'label' => 'Total Belanja', 
                      'value' => 'Rp ' . number_format($stats['totalPurchase'], 0, ',', '.'), 
                      'unit' => 'Barang Diterima',
                      'color' => 'success', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                  ],
              ];
          @endphp

          @foreach($cards as $card)
          <div class="group relative rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
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

      <!-- Seksi 2: Tren Belanja -->
      <div class="mb-4 flex items-center gap-2">
          <div class="p-1.5 rounded-md bg-brand-500 text-white">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
          </div>
          <h2 class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-[2px]">Analisis Pengadaan</h2>
      </div>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
          <!-- Grafik Tren Belanja -->
          <div class="lg:col-span-8 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
              <div class="flex items-center justify-between mb-8">
                  <h3 class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tren Pengeluaran Belanja (6 Bulan)</h3>
                  <div class="flex items-center gap-2">
                      <span class="flex h-2 w-2 rounded-full bg-brand-500"></span>
                      <span class="text-[9px] font-bold text-gray-500 uppercase">PURCHASE VOLUME</span>
                  </div>
              </div>
              <div id="purchaseTrendChart" class="w-full min-h-[300px]"></div>
          </div>

          <!-- Performa Vendor -->
          <div class="lg:col-span-4 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
              <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-6">Top Vendor Teraktif</h3>
              <div class="space-y-6">
                  @foreach($vendorPerformance as $vendor)
                  <div class="flex items-center gap-4">
                      <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400 font-bold text-sm">
                          {{ substr($vendor->name, 0, 1) }}
                      </div>
                      <div class="flex-1 min-w-0">
                          <h4 class="text-[11px] font-bold text-gray-900 dark:text-white uppercase truncate">{{ $vendor->name }}</h4>
                          <div class="flex items-center gap-2 mt-1">
                              <div class="h-1 flex-1 bg-gray-100 rounded-full overflow-hidden dark:bg-gray-800">
                                  <div class="h-full bg-brand-500" style="width: {{ min(100, $vendor->purchase_orders_count * 10) }}%"></div>
                              </div>
                              <span class="text-[9px] font-bold text-gray-400">{{ $vendor->purchase_orders_count }} PO</span>
                          </div>
                      </div>
                  </div>
                  @endforeach
              </div>
          </div>
      </div>

      <!-- Seksi 3: Tugas & Peringatan -->
      <div class="mb-4 flex items-center gap-2">
          <div class="p-1.5 rounded-md bg-error-500 text-white">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          </div>
          <h2 class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-[2px]">Tugas & Peringatan Stok</h2>
      </div>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
          <!-- Tabel Antrean PO -->
          <div class="lg:col-span-8 rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
              <div class="flex items-center justify-between border-b border-gray-50 px-6 py-4 dark:border-gray-800 bg-gray-50/10">
                  <h3 class="text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-widest">Transaksi Pembelian Terakhir</h3>
                  <a href="{{ route('purchase-orders.index') }}" class="text-[9px] font-bold text-brand-600 hover:underline uppercase">Manajemen PO</a>
              </div>
              <div class="overflow-x-auto w-full">
                  <table class="w-full text-left text-xs min-w-[500px]">
                      <thead class="bg-gray-50/50 dark:bg-white/[0.02]">
                          <tr>
                              <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Nomor PO</th>
                              <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Supplier</th>
                              <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Status</th>
                              <th class="px-6 py-3 text-right font-bold text-gray-400 uppercase text-[9px]">Total</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                          @foreach($recentPurchases as $po)
                          <tr class="hover:bg-gray-50/30 transition-colors">
                              <td class="px-6 py-4 font-mono font-bold text-brand-600 text-[10px] italic">#{{ $po->po_number }}</td>
                              <td class="px-6 py-4 text-gray-900 dark:text-white uppercase font-bold">{{ $po->supplier->name }}</td>
                              <td class="px-6 py-4">
                                  @switch($po->status)
                                      @case('received')
                                          <span class="px-2 py-0.5 rounded bg-success-50 text-[9px] font-bold uppercase text-success-600 dark:bg-success-500/10">Received</span>
                                          @break
                                      @case('pending')
                                          <span class="px-2 py-0.5 rounded bg-warning-50 text-[9px] font-bold uppercase text-warning-600 dark:bg-warning-500/10">Pending</span>
                                          @break
                                      @default
                                          <span class="px-2 py-0.5 rounded bg-gray-100 text-[9px] font-bold uppercase text-gray-500 dark:bg-gray-800">{{ $po->status }}</span>
                                  @endswitch
                              </td>
                              <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">Rp{{ number_format($po->total_amount, 0, ',', '.') }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>

          <!-- Alert Stok Kritis -->
          <div class="lg:col-span-4 rounded-2xl bg-gray-900 p-6 text-white shadow-xl relative overflow-hidden group">
              <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-error-500/10 blur-3xl"></div>
              <h4 class="text-[10px] font-bold uppercase tracking-[2px] mb-6 text-gray-400 flex items-center gap-2">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                  Restock Urgent
              </h4>
              <div class="space-y-4 relative z-10">
                  @forelse($lowStockProducts->take(4) as $prod)
                  <div class="flex justify-between items-center border-b border-white/5 pb-3 last:border-0">
                      <div class="flex flex-col">
                          <span class="text-[10px] font-bold text-white uppercase">{{ $prod->name }}</span>
                          <span class="text-[8px] text-gray-500 uppercase">{{ $prod->category->name }}</span>
                      </div>
                      <span class="text-[10px] font-black text-error-400">{{ $prod->stock }} {{ $prod->unit }}</span>
                  </div>
                  @empty
                      <p class="text-[10px] text-gray-500 italic text-center py-4">Semua stok aman.</p>
                  @endforelse
                  
                  <div class="pt-4">
                      <a href="{{ route('purchase-orders.create') }}" class="block w-full text-center py-3 rounded-xl bg-error-600 text-[10px] font-black uppercase tracking-widest hover:bg-error-700 transition shadow-lg shadow-error-900/40">
                          Proses Pengadaan
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          new ApexCharts(document.querySelector("#purchaseTrendChart"), {
              series: [{ name: 'Volume Belanja', data: @json($purchaseTrend['values']) }],
              chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
              colors: ['#3C50E0'],
              stroke: { curve: 'smooth', width: 3 },
              fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [0, 100] } },
              dataLabels: { enabled: false },
              xaxis: { categories: @json($purchaseTrend['labels']), axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { colors: '#9ca3af', fontSize: '10px', fontWeight: 600 } } },
              yaxis: { labels: { style: { colors: '#9ca3af', fontSize: '10px', fontWeight: 600 }, formatter: (val) => 'Rp' + (val / 1000000).toFixed(1) + 'M' } },
              grid: { borderColor: '#f1f1f1', strokeDashArray: 5 }
          }).render();
      });
  </script>
@endsection
