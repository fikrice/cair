@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Supplier</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi supplier <span class="font-semibold text-brand-500">{{ $supplier->code }}</span>.</p>
        </div>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('suppliers.index') }}">Supplier /</a></li>
                <li class="font-medium text-brand-500">Edit</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Informasi Utama</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Kode Supplier</label>
                                <input type="text" name="code" value="{{ old('code', $supplier->code) }}" required readonly
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm font-mono font-bold text-brand-600 outline-hidden dark:border-gray-700 dark:bg-gray-800 dark:text-brand-400 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
                                <div class="relative z-20">
                                    <select name="status" required class="w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                        <option value="active" {{ old('status', $supplier->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status', $supplier->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2 text-gray-500 pointer-events-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Perusahaan / Supplier <span class="text-error-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            @error('name') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Kontak (PIC)</label>
                                <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">NPWP</label>
                                <input type="text" name="npwp" value="{{ old('npwp', $supplier->npwp) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Alamat & Lokasi</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">{{ old('address', $supplier->address) }}</textarea>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $supplier->city) }}"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Kontak</h3>
                    <div class="space-y-5">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">No. Telepon</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
                                <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent py-3 pl-11 pr-4 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
                                <input type="email" name="email" value="{{ old('email', $supplier->email) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent py-3 pl-11 pr-4 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Catatan Internal</h3>
                    <textarea name="notes" rows="3" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">{{ old('notes', $supplier->notes) }}</textarea>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-brand-600 shadow-theme-xs">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4.16666 10L8.33333 14.1667L15.8333 5.83334" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('suppliers.index') }}" class="flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3.5 text-sm font-bold text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:bg-white/[0.05]">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
