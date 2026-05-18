@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Purchase Order</h2>
            <p class="text-sm text-gray-500">Ubah draf pesanan <span class="font-bold text-brand-500">{{ $purchaseOrder->po_number }}</span>.</p>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('purchase-orders.index') }}">PO /</a></li>
                <li class="font-medium text-brand-500">Edit</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('purchase-orders.update', $purchaseOrder) }}" method="POST" x-data="poForm()">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <!-- Left: PO Header (2/3) -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Info Utama -->
                <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Informasi Dasar</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">No. PO</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                                    </span>
                                    <input type="text" value="{{ $purchaseOrder->po_number }}" readonly
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-11 pr-4 py-3 text-sm font-mono font-bold text-brand-600 dark:border-gray-800 dark:bg-white/5 dark:text-brand-400">
                                </div>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Supplier <span class="text-error-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </span>
                                    <select name="supplier_id" required class="w-full appearance-none rounded-lg border border-gray-300 bg-transparent pl-11 pr-10 py-3 text-sm outline-hidden focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                        <option value="">Pilih Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ $purchaseOrder->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }} ({{ $supplier->code }})</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal PO <span class="text-error-500">*</span></label>
                                <input type="date" name="po_date" value="{{ $purchaseOrder->po_date->format('Y-m-d') }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Estimasi Tiba</label>
                                <input type="date" name="expected_delivery_date" value="{{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('Y-m-d') : '' }}"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-white/[0.02] rounded-t-2xl">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Produk yang Dipesan</h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-brand-500 hover:text-brand-600 transition">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Baris
                        </button>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-6 py-3 text-start font-medium uppercase tracking-tighter text-[11px]">Produk</th>
                                    <th class="px-6 py-3 text-start font-medium uppercase tracking-tighter text-[11px] w-24">Qty</th>
                                    <th class="px-6 py-3 text-start font-medium uppercase tracking-tighter text-[11px] w-44">Harga Beli</th>
                                    <th class="px-6 py-3 text-end font-medium uppercase tracking-tighter text-[11px] w-44">Subtotal</th>
                                    <th class="px-6 py-3 w-12"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800/50">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="group hover:bg-gray-50/30 dark:hover:bg-white/[0.01]">
                                        <td class="px-6 py-4">
                                            <select :name="`items[${index}][product_id]`" x-model="item.product_id" @change="updatePrice(index)" required
                                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm outline-hidden focus:border-brand-500 dark:border-gray-800 dark:bg-transparent dark:text-white">
                                                <option value="">Cari produk...</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" min="1" required
                                                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-center font-bold outline-hidden focus:border-brand-500 dark:border-gray-800 dark:bg-transparent dark:text-white">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">Rp</span>
                                                <input type="number" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" min="0" required
                                                    class="w-full rounded-lg border border-gray-200 bg-white pl-8 pr-3 py-2 text-sm font-medium outline-hidden focus:border-brand-500 dark:border-gray-800 dark:bg-transparent dark:text-white text-end">
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
                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total Pesanan</span>
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
                <!-- Notes -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="text-gray-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Catatan</h3>
                    </div>
                    <textarea name="notes" rows="4" placeholder="Contoh: Lampirkan invoice, barang fragile..."
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white leading-relaxed">{{ $purchaseOrder->notes }}</textarea>
                </div>

                <!-- Final Actions -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Aksi Akhir</h3>
                    <div class="flex flex-col gap-3">
                        <button type="submit" name="status" value="pending" class="flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 px-6 py-4 text-sm font-bold text-white transition hover:bg-brand-600 shadow-theme-lg active:scale-95">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                            Update & Kirim (Pending)
                        </button>
                        <button type="submit" name="status" value="draft" class="flex w-full items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3.5 text-sm font-bold text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Perubahan
                        </button>
                        <div class="h-px bg-gray-100 dark:bg-gray-800 my-2"></div>
                        <a href="{{ route('purchase-orders.show', $purchaseOrder) }}" class="text-center text-xs font-medium text-gray-500 hover:text-error-500 transition">Batalkan Perubahan</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        function poForm() {
            return {
                items: @json($purchaseOrder->items->map(fn($i) => ['product_id' => $i->product_id, 'quantity' => $i->quantity, 'unit_price' => $i->unit_price])),
                addItem() {
                    this.items.push({ product_id: '', quantity: 1, unit_price: 0 });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                updatePrice(index) {
                    const select = event.target;
                    const option = select.options[select.selectedIndex];
                    const price = option.getAttribute('data-price');
                    if (price) {
                        this.items[index].unit_price = parseFloat(price);
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
