@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-(--breakpoint-2xl) px-4 md:px-6 2xl:px-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-gray-900 dark:text-white">
                Edit Kategori
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a>
                    </li>
                    <li>
                        <a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('categories.index') }}">Kategori /</a>
                    </li>
                    <li class="font-medium text-brand-500">Edit</li>
                </ol>
            </nav>
        </div>
        <!-- Breadcrumb End -->

        <div class="max-w-2xl">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Kategori</h3>
                    <p class="mt-1 text-sm text-gray-500">Sesuaikan nama kategori produk skincare Anda.</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Kategori <span class="text-error-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ $category->name }}" placeholder="Contoh: Serum Wajah" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    
                                    @error('name')
                                        <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4">
                                <a href="{{ route('categories.index') }}" 
                                    class="flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-bold text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:bg-white/[0.05]">
                                    Batal
                                </a>
                                <button type="submit" 
                                    class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-600 shadow-theme-xs">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4.16666 10L8.33333 14.1667L15.8333 5.83334" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
