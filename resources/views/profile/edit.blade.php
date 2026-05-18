@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Profil & Pengaturan Akun</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola informasi pribadi, keamanan, dan preferensi akun Anda.</p>
    </div>

    <!-- ====== Profile Cover Section ====== -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <div class="relative z-20 h-32 md:h-56">
            <!-- Cover Photo Background -->
            @if(auth()->user()->cover)
                <img src="{{ asset('storage/' . auth()->user()->cover) }}" alt="cover" class="h-full w-full rounded-t-2xl object-cover object-center" />
            @else
                <div class="h-full w-full bg-gradient-to-r from-brand-500 to-blue-500 rounded-t-2xl object-cover object-center relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white opacity-10"></div>
                    <div class="absolute -left-10 -bottom-10 h-40 w-40 rounded-full bg-white opacity-10"></div>
                </div>
            @endif
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" x-data x-ref="coverForm" class="absolute bottom-4 right-4 z-10">
                @csrf
                @method('patch')
                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                <label for="cover" class="flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-white/80 dark:bg-gray-800/80 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 backdrop-blur shadow-sm border border-gray-200 dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition">
                    <input type="file" name="cover" id="cover" class="sr-only" @change="$refs.coverForm.submit()" accept="image/*" />
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <span>Ubah Sampul</span>
                </label>
            </form>
        </div>
        <div class="px-4 pb-6 text-center lg:pb-8 xl:pb-11.5">
            <div class="relative z-30 mx-auto -mt-16 h-32 w-32 rounded-full border-4 border-white bg-white dark:border-gray-900 dark:bg-gray-800 sm:-mt-20 sm:h-40 sm:w-40 shadow-lg">
                <div class="relative flex h-full w-full items-center justify-center overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800 z-10">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="avatar" class="h-full w-full object-cover" />
                    @else
                        <span class="text-4xl font-bold text-gray-400 dark:text-gray-500 uppercase">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                    @endif
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" x-data x-ref="avatarForm" class="absolute bottom-0 right-0 z-20 sm:bottom-2 sm:right-2">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <label for="avatar" class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-brand-500 text-white hover:bg-brand-600 transition shadow-md border-2 border-white dark:border-gray-900">
                        <input type="file" name="avatar" id="avatar" class="sr-only" @change="$refs.avatarForm.submit()" accept="image/*" />
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </label>
                </form>

                </div>
            @php
                $roleLabels = [
                    'admin' => 'Administrator',
                    'warehouse' => 'Petugas Gudang',
                    'finance' => 'Bagian Keuangan',
                    'purchasing' => 'Bagian Pembelian',
                ];
                $userRole = auth()->user()->role;
                $roleLabel = $roleLabels[$userRole] ?? ucfirst($userRole);

                $permissionsMap = [
                    'admin' => ['Master Data', 'Dashboard', 'Pengaturan', 'Laporan'],
                    'warehouse' => ['Katalog Produk', 'Mutasi Stok', 'Penyesuaian Stok'],
                    'finance' => ['Faktur Penjualan', 'Transaksi', 'Laporan Keuangan'],
                    'purchasing' => ['Purchase Order', 'Data Supplier', 'Laporan Pembelian'],
                ];
                $userPermissions = $permissionsMap[$userRole] ?? ['Dashboard'];
            @endphp
            <div class="mt-4">
                <h3 class="mb-1 text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                <p class="font-medium text-gray-500 text-sm flex items-center justify-center gap-2">
                    <span class="inline-flex h-2 w-2 rounded-full bg-success-500"></span>
                    {{ $roleLabel }}
                </p>
                <div class="mt-4 flex items-center justify-center gap-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-white/[0.03] dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        {{ auth()->user()->email }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-white/[0.03] dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Bergabung sejak {{ auth()->user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ====== Profile Cover Section End ====== -->

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-1 space-y-6">
            <!-- Sidebar Info -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6 shadow-theme-xs">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-500"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Tentang Akun
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed dark:text-gray-400">
                    Ini adalah profil administratif Anda untuk sistem ERP Mesama Global Indonesia. Jaga kerahasiaan informasi login Anda dan pastikan email yang digunakan selalu aktif untuk menerima pemberitahuan sistem.
                </p>
                <div class="mt-6 border-t border-gray-100 pt-6 dark:border-gray-800">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Hak Akses ({{ $roleLabel }})</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($userPermissions as $perm)
                            <span class="inline-flex rounded-full bg-brand-50 px-2.5 py-1 text-xs font-bold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">{{ $perm }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 space-y-6">
            {{-- Update Profile Information --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6 shadow-theme-xs">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 pb-5 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Pribadi</h3>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6 shadow-theme-xs">
                <div class="mb-5 flex items-center justify-between border-b border-gray-100 pb-5 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ubah Password</h3>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="rounded-2xl border border-error-200 bg-error-50/30 p-5 dark:border-error-500/30 dark:bg-error-500/5 lg:p-6 shadow-theme-xs">
                <div class="mb-5 flex items-center justify-between border-b border-error-200 pb-5 dark:border-error-500/30">
                    <h3 class="text-lg font-bold text-error-600 dark:text-error-500 flex items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        Hapus Akun
                    </h3>
                </div>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
