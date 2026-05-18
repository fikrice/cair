@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-(--breakpoint-2xl) px-4 md:px-6 2xl:px-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-gray-900 dark:text-white">
                    Tambah Produk
                </h2>
                <p class="text-sm text-gray-500">Daftarkan SKU skincare baru ke sistem Mesama ERP.</p>
            </div>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a>
                    </li>
                    <li>
                        <a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('products.index') }}">Produk /</a>
                    </li>
                    <li class="font-medium text-brand-500">Tambah</li>
                </ol>
            </nav>
        </div>
        <!-- Breadcrumb End -->

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Left Content: Primary Info (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- General Information Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] lg:p-8">
                        <div class="mb-6 border-b border-gray-100 pb-4 dark:border-gray-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Dasar</h3>
                            <p class="text-sm text-gray-500">Detail identitas produk yang akan ditampilkan di katalog.</p>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Produk <span class="text-error-500">*</span>
                                </label>
                                <input type="text" name="name" placeholder="Contoh: Acne Care Night Cream 30g" value="{{ old('name') }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @error('name') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        SKU / Kode Produk <span class="text-error-500">*</span>
                                    </label>
                                    <input type="text" name="sku" placeholder="MSM-SK-001" value="{{ old('sku') }}" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white uppercase">
                                    @error('sku') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Kategori <span class="text-error-500">*</span>
                                    </label>
                                    <div class="relative z-20">
                                        <select name="category_id" required
                                            class="w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2 text-gray-500">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </span>
                                    </div>
                                    @error('category_id') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Deskripsi Produk</label>
                                <textarea name="description" rows="4" placeholder="Jelaskan manfaat, kandungan, atau cara penggunaan produk..."
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Inventory Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] lg:p-8">
                        <div class="mb-6 border-b border-gray-100 pb-4 dark:border-gray-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Harga & Stok</h3>
                            <p class="text-sm text-gray-500">Kelola nilai jual dan ketersediaan stok produk.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Harga Beli (Modal) <span class="text-error-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">Rp</span>
                                    <input type="number" name="purchase_price" placeholder="0" value="{{ old('purchase_price') }}" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent py-3 pl-12 pr-4 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white font-medium">
                                </div>
                                @error('purchase_price') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Harga Jual <span class="text-error-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">Rp</span>
                                    <input type="number" name="selling_price" placeholder="0" value="{{ old('selling_price') }}" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent py-3 pl-12 pr-4 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white font-semibold">
                                </div>
                                @error('selling_price') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Stok Awal</label>
                                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Stok Minimal <span class="text-error-500">*</span></label>
                                <input type="number" name="min_stock" value="{{ old('min_stock', 5) }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Media & Actions (1/3) -->
                <div class="space-y-6">
                    <!-- Photo Upload Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Foto Produk</h3>
                        
                        <div x-data="{ photoName: null, photoPreview: null }" class="space-y-4">
                            <!-- Hidden File Input -->
                            <input type="file" name="image" class="hidden" x-ref="photo"
                                @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                ">

                            <!-- Preview Container -->
                            <div class="relative h-48 w-full rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50 transition hover:border-brand-500"
                                @click="$refs.photo.click()" class="cursor-pointer">
                                
                                <!-- Placeholder -->
                                <div x-show="! photoPreview" class="flex flex-col items-center justify-center h-full text-center p-4">
                                    <svg class="mb-3 text-gray-400" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <p class="text-xs font-medium text-gray-500">Klik untuk unggah foto</p>
                                    <p class="mt-1 text-[10px] text-gray-400">JPG, PNG atau WebP (Maks. 2MB)</p>
                                </div>

                                <!-- Image Preview -->
                                <div x-show="photoPreview" class="h-full w-full p-2">
                                    <img :src="photoPreview" class="h-full w-full rounded-lg object-cover shadow-sm">
                                    <button type="button" @click.stop="photoPreview = null; photoName = null; $refs.photo.value = ''"
                                        class="absolute top-3 right-3 flex h-7 w-7 items-center justify-center rounded-full bg-error-500 text-white shadow-lg hover:bg-error-600 transition">
                                        <svg width="14" height="14" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('image') <p class="mt-2 text-xs text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Unit Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                        <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Satuan <span class="text-error-500">*</span></label>
                        <div class="relative z-20">
                            <select name="unit" required
                                class="w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <option value="Pcs" {{ old('unit') == 'Pcs' ? 'selected' : '' }}>Pcs (Pieces)</option>
                                <option value="Botol" {{ old('unit') == 'Botol' ? 'selected' : '' }}>Botol</option>
                                <option value="Tube" {{ old('unit') == 'Tube' ? 'selected' : '' }}>Tube</option>
                                <option value="Pot" {{ old('unit') == 'Pot' ? 'selected' : '' }}>Pot</option>
                                <option value="Box" {{ old('unit') == 'Box' ? 'selected' : '' }}>Box</option>
                            </select>
                            <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2 text-gray-500">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </div>
                    </div>

                    <!-- Action Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex flex-col gap-4">
                            <button type="submit" 
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-brand-600 shadow-theme-xs">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 4.16666V15.8333M4.16666 10H15.8333" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Simpan Produk
                            </button>
                            <a href="{{ route('products.index') }}" 
                                class="flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3.5 text-sm font-bold text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:bg-white/[0.05]">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
