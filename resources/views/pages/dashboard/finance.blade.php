@extends('layouts.app')

@section('content')
  <!-- Main Dashboard Container -->
  <div class="w-full space-y-6">
      
      <!-- Header Dashboard -->
      <div class="mb-6">
          <h1 class="text-xl font-semibold text-gray-900 dark:text-white uppercase tracking-tight">Pusat Kendali Keuangan</h1>
          <p class="text-xs text-gray-500 font-medium italic">Analisis arus kas, penagihan, dan profitabilitas real-time.</p>
      </div>

      <!-- Seksi 1: KPI Finansial -->
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
          @php
              $cards = [
                  [
                      'label' => 'Total Pendapatan', 
                      'value' => 'Rp ' . number_format($stats['totalSales'], 0, ',', '.'), 
                      'unit' => 'Sudah Lunas',
                      'color' => 'success', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                  ],
                  [
                      'label' => 'Tagihan Menunggu', 
                      'value' => 'Rp ' . number_format($totalReceivables, 0, ',', '.'), 
                      'unit' => 'Belum Dibayar',
                      'color' => 'warning', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'
                  ],
                  [
                      'label' => 'Total Pengeluaran', 
                      'value' => 'Rp ' . number_format($stats['totalPurchase'], 0, ',', '.'), 
                      'unit' => 'Belanja Stok',
                      'color' => 'error', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>'
                  ],
                  [
                      'label' => 'Antrean Validasi', 
                      'value' => $pendingPayments->count() . ' Invoice', 
                      'unit' => 'Butuh Tindakan',
                      'color' => 'brand', 
                      'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>'
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

      <!-- Seksi 2: Visualisasi Tren -->
      <div class="mb-4 flex items-center gap-2">
          <div class="p-1.5 rounded-md bg-success-500 text-white">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg>
          </div>
          <h2 class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-[2px]">Analisis Arus Kas</h2>
      </div>

      <div class="rounded-2xl border border-gray-100 bg-white p-4 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
              <div class="flex flex-col">
                  <h3 class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tren Arus Kas (6 Bulan Terakhir)</h3>
                  <span class="text-[9px] text-gray-400 italic">Perbandingan akumulasi dana masuk vs keluar</span>
              </div>
              <div class="flex items-center gap-4 mt-2 sm:mt-0">
                  <div class="flex items-center gap-1.5"><div class="h-2 w-2 rounded-full bg-success-500"></div><span class="text-[9px] font-bold text-gray-500 uppercase">MASUK</span></div>
                  <div class="flex items-center gap-1.5"><div class="h-2 w-2 rounded-full bg-error-500"></div><span class="text-[9px] font-bold text-gray-500 uppercase">KELUAR</span></div>
              </div>
          </div>
          <div class="relative w-full overflow-hidden">
              <div id="financeChart" class="w-full min-h-[320px] max-w-full"></div>
          </div>
      </div>

      <!-- Seksi 3: Aktivitas Operasional -->
      <div class="mb-4 flex items-center gap-2">
          <div class="p-1.5 rounded-md bg-brand-500 text-white">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <h2 class="text-[11px] font-bold text-gray-900 dark:text-white uppercase tracking-[2px]">Tugas Operasional Keuangan</h2>
      </div>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
          <!-- Pusat Komando Tagihan (SO & PO) -->
          <div class="lg:col-span-8 space-y-6">
              <!-- Tabel Piutang Pelanggan (SO) -->
              <div class="rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                  <div class="flex items-center justify-between border-b border-gray-50 px-6 py-4 dark:border-gray-800 bg-gray-50/10">
                      <div class="flex items-center gap-2">
                          <span class="h-1.5 w-1.5 rounded-full bg-success-500 animate-pulse"></span>
                          <h3 class="text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-widest">Piutang Pelanggan (SO) - Menunggu Pelunasan</h3>
                      </div>
                      <a href="{{ route('sales-orders.index') }}" class="text-[9px] font-bold text-brand-600 hover:underline uppercase">Semua SO</a>
                  </div>
                  <div class="overflow-x-auto w-full">
                      <table class="w-full text-left text-xs min-w-[500px]">
                          <thead class="bg-gray-50/50 dark:bg-white/[0.02]">
                              <tr>
                                  <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Invoice</th>
                                  <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Pelanggan</th>
                                  <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Total Tagihan</th>
                                  <th class="px-6 py-3"></th>
                              </tr>
                          </thead>
                          <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                              @forelse($pendingPayments as $so)
                              <tr class="hover:bg-gray-50/30 transition-colors group">
                                  <td class="px-6 py-4 font-mono font-bold text-gray-900 dark:text-white text-[10px]">{{ $so->so_number }}</td>
                                  <td class="px-6 py-4 text-gray-600 dark:text-gray-400 uppercase font-medium truncate max-w-[150px]">{{ $so->customer_name }}</td>
                                  <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">Rp{{ number_format($so->total_amount, 0, ',', '.') }}</td>
                                  <td class="px-6 py-4 text-right">
                                      <a href="{{ route('sales-orders.payment', $so) }}" class="inline-flex items-center gap-2 rounded-md bg-brand-500 px-3 py-1.5 text-[9px] font-bold text-white uppercase hover:bg-brand-600 transition shadow-sm">
                                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                          Terima Bayar
                                      </a>
                                  </td>
                              </tr>
                              @empty
                              <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Semua tagihan customer sudah terbayar.</td></tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>

              <!-- Tabel Utang Supplier (PO) -->
              <div class="rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                  <div class="flex items-center justify-between border-b border-gray-50 px-6 py-4 dark:border-gray-800 bg-gray-50/10">
                      <div class="flex items-center gap-2">
                          <span class="h-1.5 w-1.5 rounded-full bg-error-500 animate-pulse"></span>
                          <h3 class="text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-widest">Utang Supplier (PO) - Menunggu Pembayaran</h3>
                      </div>
                      <a href="{{ route('purchase-orders.index') }}" class="text-[9px] font-bold text-brand-600 hover:underline uppercase">Semua PO</a>
                  </div>
                  <div class="overflow-x-auto w-full">
                      <table class="w-full text-left text-xs min-w-[500px]">
                          <thead class="bg-gray-50/50 dark:bg-white/[0.02]">
                              <tr>
                                  <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Nomor PO</th>
                                  <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Supplier</th>
                                  <th class="px-6 py-3 font-bold text-gray-400 uppercase text-[9px]">Total Tagihan</th>
                                  <th class="px-6 py-3"></th>
                              </tr>
                          </thead>
                          <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                              @forelse($pendingPurchases as $po)
                              <tr class="hover:bg-gray-50/30 transition-colors group">
                                  <td class="px-6 py-4 font-mono font-bold text-gray-900 dark:text-white text-[10px]">{{ $po->po_number }}</td>
                                  <td class="px-6 py-4 text-gray-600 dark:text-gray-400 uppercase font-medium truncate max-w-[150px]">{{ $po->supplier->name ?? 'SUPPLIER' }}</td>
                                  <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">Rp{{ number_format($po->total_amount, 0, ',', '.') }}</td>
                                  <td class="px-6 py-4 text-right">
                                      <a href="{{ route('purchase-orders.payment', $po) }}" class="inline-flex items-center gap-2 rounded-md bg-error-500 px-3 py-1.5 text-[9px] font-bold text-white uppercase hover:bg-error-600 transition shadow-sm">
                                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                          Bayar Supplier
                                      </a>
                                  </td>
                              </tr>
                              @empty
                              <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Semua tagihan supplier sudah lunas dibayar.</td></tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

          <!-- Ringkasan Laba -->
          <div class="lg:col-span-4 rounded-2xl bg-gray-900 p-6 text-white shadow-xl relative overflow-hidden group self-start">
              <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-brand-500/10 blur-3xl transition-all group-hover:bg-brand-500/20"></div>
              <h4 class="text-[10px] font-bold uppercase tracking-[2px] mb-6 text-gray-400 flex items-center gap-2">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                  Perhitungan Laba
              </h4>
              <div class="space-y-6 relative z-10">
                  <div class="flex justify-between items-center border-b border-white/10 pb-4">
                      <span class="text-[10px] text-gray-400">Total Penjualan</span>
                      <span class="text-xs font-bold text-success-400 italic">Rp{{ number_format($stats['totalSales'], 0, ',', '.') }}</span>
                  </div>
                  <div class="flex justify-between items-center border-b border-white/10 pb-4">
                      <span class="text-[10px] text-gray-400">Total Belanja</span>
                      <span class="text-xs font-bold text-error-400 italic">Rp{{ number_format($stats['totalPurchase'], 0, ',', '.') }}</span>
                  </div>
                  <div class="pt-2">
                      <div class="flex justify-between items-center mb-3">
                          <span class="text-[10px] text-gray-400 italic">Persentase Laba</span>
                          <span class="text-sm font-black text-brand-400">{{ $stats['totalSales'] > 0 ? number_format(($stats['totalSales'] - $stats['totalPurchase']) / $stats['totalSales'] * 100, 1) : 0 }}%</span>
                      </div>
                      <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                          <div class="bg-brand-500 h-full shadow-[0_0_12px_rgba(59,130,246,0.6)] transition-all duration-1000" style="width: {{ $stats['totalSales'] > 0 ? min(100, ($stats['totalSales'] - $stats['totalPurchase']) / $stats['totalSales'] * 100) : 0 }}%"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          new ApexCharts(document.querySelector("#financeChart"), {
              series: [{ name: 'Uang Masuk', data: @json($financeChart['revenue']) }, { name: 'Uang Keluar', data: @json($financeChart['expense']) }],
              chart: { type: 'bar', height: 320, width: '100%', toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
              colors: ['#10B981', '#EF4444'],
              plotOptions: { bar: { horizontal: false, columnWidth: '35%', borderRadius: 6 } },
              dataLabels: { enabled: false },
              stroke: { show: true, width: 2, colors: ['transparent'] },
              xaxis: { categories: @json($financeChart['labels']), axisBorder: { show: false }, axisTicks: { show: false } },
              yaxis: { labels: { formatter: (val) => 'Rp' + val.toLocaleString('id-ID') } },
              fill: { opacity: 1 },
              grid: { borderColor: '#f9fafb', strokeDashArray: 4 },
              legend: { show: false }
          }).render();
      });
  </script>
@endsection
