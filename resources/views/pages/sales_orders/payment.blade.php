@extends('layouts.app')

@section('content')
    <!-- Header & Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Validasi Pembayaran</h2>
            <p class="text-xs text-gray-500 font-medium italic">Konfirmasi penerimaan dana untuk memproses pengiriman barang.</p>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                <li><a class="hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><span class="px-1">/</span></li>
                <li><a class="hover:text-brand-500 transition" href="{{ route('sales-orders.index') }}">Sales Order</a></li>
                <li><span class="px-1">/</span></li>
                <li class="text-brand-500">Proses Bayar</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <!-- Kolom Kiri: Ringkasan Invoice (Informasi) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="mb-6 flex items-center justify-between">
                    <span class="inline-flex items-center rounded-lg bg-brand-50 px-3 py-1 text-[10px] font-bold text-brand-600 dark:bg-brand-500/10">DATA INVOICE</span>
                    <span class="text-[10px] font-mono font-bold text-gray-400 italic">#{{ $salesOrder->so_number }}</span>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Pelanggan</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white uppercase mt-1">{{ $salesOrder->customer_name }}</p>
                    </div>
                    
                    <div class="pt-4 border-t border-dashed border-gray-100 dark:border-gray-800">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ringkasan Nilai Tagihan</p>
                        <div class="mt-3 space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Total Nilai Pesanan</span>
                                <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($salesOrder->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Dana Sudah Diterima</span>
                                <span class="font-medium text-success-600">- Rp {{ number_format($salesOrder->total_amount - $remainingAmount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 mt-2 border-t border-gray-50 dark:border-gray-800">
                                <span class="text-[10px] font-bold text-gray-900 dark:text-white uppercase">Sisa Tagihan</span>
                                <span class="text-lg font-black text-brand-600 dark:text-brand-400">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Petunjuk Keuangan -->
            <div class="rounded-2xl bg-gray-900 p-6 text-white shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h4 class="text-[10px] font-bold uppercase tracking-[2px] mb-4 text-brand-400">Panduan Finance</h4>
                <p class="text-xs text-gray-400 leading-relaxed italic">Pastikan nominal yang Anda masukkan sesuai dengan bukti transfer atau uang tunai yang diterima. Status pesanan akan berubah menjadi "Completed" setelah pembayaran lunas.</p>
            </div>
        </div>

        <!-- Kolom Kanan: Form Pembayaran -->
        <div class="lg:col-span-7">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/5 flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-success-500 text-white flex items-center justify-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-tight">Formulir Validasi Pembayaran</h3>
                </div>
                
                <form action="{{ route('transactions.store') }}" method="POST" class="p-6">
                    @csrf
                    <!-- Data SO Hidden -->
                    <input type="hidden" name="sales_order_id" value="{{ $salesOrder->id }}">
                    <input type="hidden" name="type" value="income">
                    <input type="hidden" name="reference_number" value="{{ $salesOrder->so_number }}">
                    <input type="hidden" name="description" value="Pembayaran SO {{ $salesOrder->so_number }} - {{ $salesOrder->customer_name }}">

                    <div class="space-y-6">
                        <!-- Nominal Input -->
                        <div class="p-5 rounded-2xl bg-brand-50/30 dark:bg-brand-500/5 border-2 border-brand-100 dark:border-brand-500/20">
                            <label class="mb-3 block text-[10px] font-bold text-brand-600 dark:text-brand-400 uppercase tracking-widest">Nominal Pembayaran Diterima <span class="text-error-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 text-2xl font-black text-brand-300">Rp</span>
                                <input type="number" name="amount" value="{{ $remainingAmount }}" max="{{ $remainingAmount }}" min="1" required
                                    class="w-full bg-transparent pl-12 pr-4 py-2 text-3xl font-black text-brand-600 outline-none focus:ring-0 dark:text-brand-400 border-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <!-- Metode Bayar -->
                            <div>
                                <label class="mb-2 flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-tight">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                    Metode Pembayaran
                                </label>
                                <select name="payment_method" required class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white transition">
                                    <option value="transfer">Transfer Bank (Mandiri/BCA)</option>
                                    <option value="cash">Tunai (Cash)</option>
                                    <option value="e-wallet">E-Wallet (QRIS/Dana)</option>
                                </select>
                            </div>
                            <!-- Tanggal Bayar -->
                            <div>
                                <label class="mb-2 flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-tight">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    Tanggal Bayar
                                </label>
                                <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required
                                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white transition">
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label class="mb-2 flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-tight">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Catatan Penagihan (Opsional)
                            </label>
                            <textarea name="note" rows="3" placeholder="Masukkan detail seperti No. Referensi Transfer atau Nama Pengirim..."
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white transition"></textarea>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition text-center uppercase tracking-widest">
                            Kembali
                        </a>
                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 rounded-xl bg-success-600 px-10 py-3.5 text-sm font-bold text-white hover:bg-success-700 transition shadow-lg shadow-success-500/20 active:scale-95">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Konfirmasi Lunas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
