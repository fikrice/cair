@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Buat Penyesuaian Stok</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('stock-adjustments.index') }}">Penyesuaian Stok /</a></li>
                <li class="font-medium text-brand-500">Baru</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Main Form Card -->
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                <div class="border-b border-gray-100 p-6 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/20">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-5 h-5 text-brand-500"></i> Detail Penyesuaian
                    </h3>
                </div>

                <form action="{{ route('stock-adjustments.store') }}" method="POST" class="p-6 sm:p-8">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Product Selection -->
                        <div class="sm:col-span-2">
                            <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Pilih Produk <span class="text-error-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_id" required class="w-full appearance-none rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                                    <option value="">Pilih produk...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} (SKU: {{ $product->sku }}) - Stok Saat Ini: {{ $product->stock }} {{ $product->unit }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="package" class="w-5 h-5"></i>
                                </span>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </span>
                            </div>
                            @error('product_id') <p class="mt-1 text-xs text-error-500 font-bold italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tipe Penyesuaian <span class="text-error-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer items-center justify-center gap-2 rounded-2xl border-2 border-gray-100 p-4 transition-all hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-900 group">
                                    <input type="radio" name="type" value="addition" class="hidden peer" {{ old('type', 'addition') == 'addition' ? 'checked' : '' }}>
                                    <div class="absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-success-500 peer-checked:bg-success-50/50 dark:peer-checked:bg-success-500/5 transition-all"></div>
                                    <div class="relative z-10 flex items-center gap-2 text-gray-500 peer-checked:text-success-600 dark:peer-checked:text-success-400">
                                        <i data-lucide="plus-circle" class="w-5 h-5 transition-transform group-active:scale-90"></i>
                                        <span class="text-sm font-bold uppercase tracking-tight">Tambah</span>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer items-center justify-center gap-2 rounded-2xl border-2 border-gray-100 p-4 transition-all hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-900 group">
                                    <input type="radio" name="type" value="subtraction" class="hidden peer" {{ old('type') == 'subtraction' ? 'checked' : '' }}>
                                    <div class="absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-error-500 peer-checked:bg-error-50/50 dark:peer-checked:bg-error-500/5 transition-all"></div>
                                    <div class="relative z-10 flex items-center gap-2 text-gray-500 peer-checked:text-error-600 dark:peer-checked:text-error-400">
                                        <i data-lucide="minus-circle" class="w-5 h-5 transition-transform group-active:scale-90"></i>
                                        <span class="text-sm font-bold uppercase tracking-tight">Kurang</span>
                                    </div>
                                </label>
                            </div>
                            @error('type') <p class="mt-1 text-xs text-error-500 font-bold italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Jumlah Qty <span class="text-error-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="quantity" min="1" placeholder="Masukkan jumlah..." value="{{ old('quantity') }}" required
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="hash" class="w-5 h-5"></i>
                                </span>
                            </div>
                            @error('quantity') <p class="mt-1 text-xs text-error-500 font-bold italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Reason -->
                        <div>
                            <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Alasan <span class="text-error-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="reason" required class="w-full appearance-none rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                                    @foreach($reasons as $val => $label)
                                        <option value="{{ $val }}" {{ old('reason') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                                </span>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </span>
                            </div>
                            @error('reason') <p class="mt-1 text-xs text-error-500 font-bold italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Adjustment Date -->
                        <div>
                            <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Tanggal Kejadian <span class="text-error-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="datetime-local" name="adjustment_date" value="{{ old('adjustment_date', now()->format('Y-m-d\TH:i')) }}" required
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i data-lucide="calendar" class="w-5 h-5"></i>
                                </span>
                            </div>
                            @error('adjustment_date') <p class="mt-1 text-xs text-error-500 font-bold italic">{{ $message }}</p> @enderror
                        </div>

                        <!-- Notes -->
                        <div class="sm:col-span-2">
                            <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Catatan Tambahan (Opsional)
                            </label>
                            <textarea name="notes" rows="4" placeholder="Jelaskan lebih detail alasan penyesuaian..."
                                class="w-full rounded-xl border border-gray-200 bg-white py-3 px-5 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-800 dark:bg-gray-900 dark:text-white">{{ old('notes') }}</textarea>
                            @error('notes') <p class="mt-1 text-xs text-error-500 font-bold italic">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-10 flex items-center justify-end gap-3 border-t border-gray-100 pt-8 dark:border-gray-800">
                        <a href="{{ route('stock-adjustments.index') }}" class="rounded-xl border border-gray-200 px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-10 py-3 text-sm font-bold text-white hover:bg-brand-600 transition shadow-theme-xs">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Simpan Penyesuaian
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="lg:col-span-1">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Panduan Penyesuaian</h4>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <i data-lucide="info" class="w-4 h-4"></i>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Gunakan tipe <strong class="text-success-600">Tambah</strong> jika Anda menemukan barang lebih saat opname atau retur vendor yang tidak tercatat.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400">
                            <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Gunakan tipe <strong class="text-error-600">Kurang</strong> untuk mencatat barang pecah, hilang, atau kadaluarsa.
                        </p>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-900 border border-gray-100 dark:border-gray-700">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Penting:</p>
                        <p class="text-[10px] text-gray-500 leading-relaxed">
                            Setiap penyesuaian akan tercatat di riwayat mutasi stok sebagai audit trail yang tidak dapat dihapus secara permanen.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endpush
