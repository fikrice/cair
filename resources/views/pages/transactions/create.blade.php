@extends('layouts.app')

@section('content')
    <!-- Header & Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20v-6M6 20V10M18 20V4"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Catat Jurnal Manual</h2>
                <p class="text-xs text-gray-500 font-medium italic">Rekam pemasukan atau pengeluaran kas di luar sistem pesanan utama.</p>
            </div>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                <li><a class="hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><span class="px-1">/</span></li>
                <li><a class="hover:text-brand-500 transition" href="{{ route('transactions.index') }}">Buku Kas</a></li>
                <li><span class="px-1">/</span></li>
                <li class="text-brand-500">Entry Jurnal</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <!-- Kolom Kiri: Form Jurnal -->
        <div class="lg:col-span-8">
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden" x-data="{ type: 'income', isLinked: false }">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-800 bg-gray-50/50 dark:bg-white/5 flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-brand-500 text-white flex items-center justify-center shadow-md shadow-brand-500/20">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-tight">Formulir Pencatatan Keuangan</h3>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    <div class="space-y-8">
                        
                        <!-- 1. Jenis Transaksi -->
                        <div>
                            <label class="mb-3 block text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-widest">Jenis Arus Kas <span class="text-error-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer items-center justify-center gap-3 rounded-xl border-2 bg-white p-4 transition-all dark:bg-gray-900" 
                                    :class="type === 'income' ? 'border-success-500 shadow-md shadow-success-500/10' : 'border-gray-100 hover:border-gray-200 dark:border-gray-800 dark:hover:border-gray-700'">
                                    <input type="radio" name="type" value="income" x-model="type" class="sr-only">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full" :class="type === 'income' ? 'bg-success-100 text-success-600 dark:bg-success-500/20' : 'bg-gray-50 text-gray-400 dark:bg-gray-800'">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    </div>
                                    <div class="text-left">
                                        <span class="block text-sm font-black uppercase tracking-tight" :class="type === 'income' ? 'text-success-700 dark:text-success-400' : 'text-gray-600 dark:text-gray-400'">Dana Masuk</span>
                                        <span class="block text-[10px] font-medium text-gray-400 mt-0.5">Penerimaan Kas</span>
                                    </div>
                                </label>
                                
                                <label class="relative flex cursor-pointer items-center justify-center gap-3 rounded-xl border-2 bg-white p-4 transition-all dark:bg-gray-900" 
                                    :class="type === 'expense' ? 'border-error-500 shadow-md shadow-error-500/10' : 'border-gray-100 hover:border-gray-200 dark:border-gray-800 dark:hover:border-gray-700'">
                                    <input type="radio" name="type" value="expense" x-model="type" class="sr-only">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full" :class="type === 'expense' ? 'bg-error-100 text-error-600 dark:bg-error-500/20' : 'bg-gray-50 text-gray-400 dark:bg-gray-800'">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                    </div>
                                    <div class="text-left">
                                        <span class="block text-sm font-black uppercase tracking-tight" :class="type === 'expense' ? 'text-error-700 dark:text-error-400' : 'text-gray-600 dark:text-gray-400'">Dana Keluar</span>
                                        <span class="block text-[10px] font-medium text-gray-400 mt-0.5">Pengeluaran Biaya</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- 2. Nominal -->
                        <div class="p-5 rounded-2xl bg-gray-50/50 dark:bg-gray-800/30 border border-gray-100 dark:border-gray-800 transition-colors"
                            :class="type === 'income' ? 'border-l-4 border-l-success-500' : 'border-l-4 border-l-error-500'">
                            <label class="mb-3 block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Nominal Transaksi <span class="text-error-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 text-2xl font-black text-gray-400">Rp</span>
                                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="1"
                                    class="w-full bg-transparent pl-12 pr-4 py-2 text-3xl font-black outline-none focus:ring-0 border-none transition-colors"
                                    :class="type === 'income' ? 'text-success-600 dark:text-success-400' : 'text-error-600 dark:text-error-400'"
                                    placeholder="0">
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- 3. Keterangan & Referensi -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="description" class="mb-2 flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-tight">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                    Judul / Keterangan Biaya <span class="text-error-500">*</span>
                                </label>
                                <input type="text" name="description" id="description" value="{{ old('description') }}" required
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm font-medium outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                    placeholder="Cth: Bayar Listrik, Pemasukan Lain...">
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            
                            <div>
                                <label for="reference_number" class="mb-2 flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-tight">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    Nomor Bukti / Referensi
                                </label>
                                <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm font-medium outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                    placeholder="INV-999 / TRX-123 (Opsional)">
                            </div>
                        </div>

                        <!-- Opsi SO (Khusus Income) -->
                        <div x-show="type === 'income'" x-collapse>
                            <div class="p-4 rounded-xl border border-brand-100 bg-brand-50/30 dark:border-brand-500/20 dark:bg-brand-500/5">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" x-model="isLinked" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border-2 border-gray-300 transition-all checked:border-brand-500 checked:bg-brand-500 dark:border-gray-600">
                                        <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none opacity-0 peer-checked:opacity-100 text-white" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                    <span class="text-sm font-bold text-brand-700 dark:text-brand-400 uppercase tracking-tight">Kaitkan Pemasukan dengan Tagihan SO?</span>
                                </label>
                                
                                <div x-show="isLinked" x-collapse class="mt-4">
                                    <div class="relative">
                                        <select name="sales_order_id" id="sales_order_id" class="w-full appearance-none rounded-xl border border-gray-200 bg-white py-3 pl-4 pr-10 text-sm font-medium outline-none transition focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                            <option value="">-- Pilih Nomor Tagihan (SO) --</option>
                                            @foreach($pendingSalesOrders as $so)
                                                <option value="{{ $so->id }}">
                                                    #{{ $so->so_number }} - {{ $so->customer_name }} (Tagihan: Rp {{ number_format($so->total_amount, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Opsi PO (Khusus Expense) -->
                        <div x-show="type === 'expense'" x-collapse>
                            <div class="p-4 rounded-xl border border-error-100 bg-error-50/30 dark:border-error-500/20 dark:bg-error-500/5">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" x-model="isLinked" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border-2 border-gray-300 transition-all checked:border-error-500 checked:bg-error-500 dark:border-gray-600">
                                        <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none opacity-0 peer-checked:opacity-100 text-white" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                    <span class="text-sm font-bold text-error-700 dark:text-error-400 uppercase tracking-tight">Kaitkan Pengeluaran dengan Tagihan PO?</span>
                                </label>
                                
                                <div x-show="isLinked" x-collapse class="mt-4">
                                    <div class="relative">
                                        <select name="purchase_order_id" id="purchase_order_id" class="w-full appearance-none rounded-xl border border-gray-200 bg-white py-3 pl-4 pr-10 text-sm font-medium outline-none transition focus:border-error-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                            <option value="">-- Pilih Nomor Tagihan (PO) --</option>
                                            @foreach($pendingPurchaseOrders as $po)
                                                <option value="{{ $po->id }}">
                                                    #{{ $po->po_number }} - {{ $po->supplier->name }} (Tagihan: Rp {{ number_format($po->total_amount, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Tanggal & Metode -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-tight">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                    Penyelesaian Dana <span class="text-error-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="payment_method" required class="w-full appearance-none rounded-xl border border-gray-200 bg-white py-3 pl-4 pr-10 text-sm font-medium outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                        <option value="transfer">Transfer Bank</option>
                                        <option value="cash">Uang Tunai (Cash)</option>
                                        <option value="e-wallet">E-Wallet (QRIS/Dana)</option>
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                    </span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="mb-2 flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-400 uppercase tracking-tight">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    Tanggal Pencatatan <span class="text-error-500">*</span>
                                </label>
                                <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm font-medium outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            </div>
                        </div>

                    </div>

                    <!-- Footer Action -->
                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-end gap-3">
                        <a href="{{ route('transactions.index') }}" class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition text-center uppercase tracking-widest">
                            Batalkan
                        </a>
                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 rounded-xl px-10 py-3.5 text-sm font-bold text-white transition shadow-lg active:scale-95"
                            :class="type === 'income' ? 'bg-success-600 hover:bg-success-700 shadow-success-500/20' : 'bg-error-600 hover:bg-error-700 shadow-error-500/20'">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Posting Jurnal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Panduan -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Info Sidebar -->
            <div class="rounded-2xl bg-gray-900 p-6 sm:p-8 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-brand-500/10 blur-3xl transition-all group-hover:bg-brand-500/20"></div>
                <h4 class="text-[10px] font-bold uppercase tracking-[2px] mb-6 text-brand-400 flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Prosedur Pencatatan
                </h4>
                
                <div class="space-y-6 relative z-10">
                    <div class="flex gap-4 items-start">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-white font-black text-xs">1</div>
                        <div>
                            <p class="text-xs font-bold text-white mb-1">Akurasi Nominal</p>
                            <p class="text-[11px] text-gray-400 leading-relaxed">Selalu pastikan angka yang diinput presisi hingga digit terakhir sesuai dengan mutasi rekening bank atau bukti kasir.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 items-start">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-white font-black text-xs">2</div>
                        <div>
                            <p class="text-xs font-bold text-white mb-1">Pengkaitan Tagihan (SO/PO)</p>
                            <p class="text-[11px] text-gray-400 leading-relaxed">Jika ini adalah pelunasan piutang (SO) atau pembayaran hutang (PO), WAJIB mengaktifkan fitur <span class="text-brand-400 font-bold">Kaitkan</span> agar status pesanan ter-update otomatis.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 items-start">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-white font-black text-xs">3</div>
                        <div>
                            <p class="text-xs font-bold text-white mb-1">Validasi Referensi</p>
                            <p class="text-[11px] text-gray-400 leading-relaxed">Gunakan kolom referensi untuk menyimpan nomor ID Bukti Transfer, Cek, atau Bilyet Giro guna memudahkan proses audit bulanan.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-white/10 relative z-10">
                    <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest text-center">Data dicatat atas nama:</p>
                    <p class="text-xs font-bold text-white text-center mt-1">@ {{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
