@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail Supplier</h2>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap supplier <span class="font-semibold text-brand-500">{{ $supplier->code }}</span>.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('suppliers.edit', $supplier) }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition shadow-theme-xs">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M12.75 3L15 5.25M14.25 1.5L16.5 3.75L6.75 13.5H4.5V11.25L14.25 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Edit
            </a>
            <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <!-- Left: Detail Info -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Header Card -->
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="p-6 flex items-start gap-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-500 dark:bg-brand-500/10">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 flex-wrap">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $supplier->name }}</h3>
                            @if($supplier->status === 'active')
                                <span class="inline-flex items-center gap-1 rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                </span>
                            @endif
                        </div>
                        <span class="mt-1 inline-flex rounded-md bg-brand-50 px-2 py-1 text-xs font-bold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 tracking-wider">{{ $supplier->code }}</span>
                        @if($supplier->contact_person)
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">PIC: {{ $supplier->contact_person }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Alamat Card -->
            <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Alamat & Lokasi</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alamat Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ $supplier->address ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kota</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-white/90">{{ $supplier->city ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Right: Kontak & Meta -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                        <div><p class="text-xs text-gray-500">Telepon</p><p class="text-sm font-medium text-gray-800 dark:text-white">{{ $supplier->phone ?? '-' }}</p></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                        <div><p class="text-xs text-gray-500">Email</p><p class="text-sm font-medium text-gray-800 dark:text-white">{{ $supplier->email ?? '-' }}</p></div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Informasi Lainnya</h3>
                <dl class="space-y-4">
                    <div><dt class="text-xs text-gray-500 uppercase tracking-wider">NPWP</dt><dd class="mt-1 text-sm font-medium text-gray-800 dark:text-white font-mono">{{ $supplier->npwp ?? '-' }}</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase tracking-wider">Catatan</dt><dd class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $supplier->notes ?? '-' }}</dd></div>
                    <div class="border-t border-gray-100 dark:border-gray-800 pt-4">
                        <dt class="text-xs text-gray-500 uppercase tracking-wider">Ditambahkan</dt><dd class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $supplier->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div><dt class="text-xs text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</dt><dd class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $supplier->updated_at->format('d M Y, H:i') }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
@endsection
