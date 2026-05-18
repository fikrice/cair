@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Buat Sales Order Baru</h2>
            <p class="text-sm text-gray-500">Catat pesanan penjualan dari pelanggan.</p>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('sales-orders.index') }}">SO /</a></li>
                <li class="font-medium text-brand-500">Tambah</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('sales-orders.store') }}" method="POST" x-data="soForm()">
        @csrf
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <!-- Left: SO Header (2/3) -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Data Pelanggan -->
                <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.02] rounded-t-2xl">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Informasi Pelanggan</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">No. SO</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    </span>
                                    <input type="text" value="{{ $soNumber }}" readonly
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-11 pr-4 py-3 text-sm font-mono font-bold text-brand-600 dark:border-gray-800 dark:bg-white/5 dark:text-brand-400">
                                </div>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Pelanggan <span class="text-error-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </span>
                                    <input type="text" name="customer_name" required placeholder="Masukkan nama pelanggan..."
                                        class="w-full rounded-lg border border-gray-300 bg-transparent pl-11 pr-4 py-3 text-sm outline-hidden focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal SO <span class="text-error-500">*</span></label>
                                <input type="date" name="so_date" value="{{ date('Y-m-d') }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">No. Telepon</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    </span>
                                    <input type="text" name="customer_phone" placeholder="0812..."
                                        class="w-full rounded-lg border border-gray-300 bg-transparent pl-11 pr-4 py-3 text-sm outline-hidden focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Produk -->
                <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-white/[0.02] rounded-t-2xl">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Produk yang Dijual</h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-brand-500 hover:text-brand-600 transition">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Produk
                        </button>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-6 py-3 text-start font-medium uppercase tracking-tighter text-[11px]">Produk</th>
                                    <th class="px-6 py-3 text-start font-medium uppercase tracking-tighter text-[11px] w-24">Stok</th>
                                    <th class="px-6 py-3 text-start font-medium uppercase tracking-tighter text-[11px] w-28">Qty</th>
                                    <th class="px-6 py-3 text-start font-medium uppercase tracking-tighter text-[11px] w-44">Harga Jual</th>
                                    <th class="px-6 py-3 text-end font-medium uppercase tracking-tighter text-[11px] w-44">Subtotal</th>
                                    <th class="px-6 py-3 w-12"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800/50">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="group hover:bg-gray-50/30 dark:hover:bg-white/[0.01]">
                                        <td class="px-6 py-4">
                                            <select :name="`items[${index}][product_id]`" x-model="item.product_id" @change="updateProductInfo(index)" required
                                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm outline-hidden focus:border-brand-500 dark:border-gray-800 dark:bg-transparent dark:text-white">
                                                <option value="">Cari produk...</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                        data-price="{{ $product->selling_price }}"
                                                        data-stock="{{ $product->stock }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400" x-text="item.stock + ' unit'"></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" :max="item.stock" min="1" required
                                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-center font-bold outline-hidden focus:border-brand-500 dark:border-gray-800 dark:bg-transparent dark:text-white">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">Rp</span>
                                                <input type="number" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" readonly
                                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-8 pr-3 py-2 text-sm font-medium outline-hidden dark:border-gray-800 dark:bg-white/5 dark:text-white text-end">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-end">
                                            <span class="text-sm font-black text-gray-900 dark:text-white" x-text="'Rp ' + formatNumber(item.quantity * item.unit_price)"></span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button type="button" @click="removeItem(index)" class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-error-50 hover:text-error-500 transition-all dark:hover:bg-error-500/10" :disabled="items.length === 1">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <!-- Grand Total Banner -->
                    <div class="p-6 bg-brand-500/5 border-t border-gray-100 dark:border-gray-800 rounded-b-2xl">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total Penjualan</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs font-bold text-brand-500">Rp</span>
                                <span class="text-3xl font-black text-brand-600 dark:text-brand-400" x-text="formatNumber(calculateTotal())"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar (1/3) -->
            <div class="space-y-6">
                <!-- Shipping -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="text-gray-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Alamat Pengiriman</h3>
                    </div>
                    <textarea name="shipping_address" rows="3" placeholder="Jl. Contoh No. 123, Jakarta..."
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
                </div>

                <!-- Final Actions -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Aksi</h3>
                    <div class="flex flex-col gap-3">
                        <button type="submit" name="status" value="processing" class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 px-6 py-4 text-sm font-bold text-white transition hover:bg-brand-600 shadow-theme-lg active:scale-95">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Buat Pesanan (Processing)
                        </button>
                        <button type="submit" name="status" value="draft" class="flex w-full items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3.5 text-sm font-bold text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400">
                            Simpan Draft
                        </button>
                        <div class="h-px bg-gray-100 dark:bg-gray-800 my-2"></div>
                        <a href="{{ route('sales-orders.index') }}" class="text-center text-xs font-medium text-gray-500 hover:text-error-500 transition">Batalkan</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        function soForm() {
            return {
                items: [{ product_id: '', quantity: 1, unit_price: 0, stock: 0 }],
                addItem() {
                    this.items.push({ product_id: '', quantity: 1, unit_price: 0, stock: 0 });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                updateProductInfo(index) {
                    const select = event.target;
                    const option = select.options[select.selectedIndex];
                    const price = option.getAttribute('data-price');
                    const stock = option.getAttribute('data-stock');
                    if (price) {
                        this.items[index].unit_price = parseFloat(price);
                        this.items[index].stock = parseInt(stock);
                    }
                },
                calculateTotal() {
                    return this.items.reduce((total, item) => total + (item.quantity * item.unit_price), 0);
                },
                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                }
            }
        }
    </script>
    @endpush
@endsection
