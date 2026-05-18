@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-(--breakpoint-2xl) px-4 md:px-6 2xl:px-10">
        <!-- Breadcrumb Start -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-gray-900 dark:text-white">
                    Edit Otoritas User
                </h2>
                <p class="text-sm text-gray-500">Perbarui profil dan konfigurasi hak akses untuk <span class="font-bold text-brand-500">{{ $user->name }}</span>.</p>
            </div>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a>
                    </li>
                    <li>
                        <a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('users.index') }}">User /</a>
                    </li>
                    <li class="font-medium text-brand-500">Edit</li>
                </ol>
            </nav>
        </div>
        <!-- Breadcrumb End -->

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Left Content: Primary Info (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- General Information Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] lg:p-8">
                        <div class="mb-6 border-b border-gray-100 pb-4 dark:border-gray-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Identitas Pengguna</h3>
                            <p class="text-sm text-gray-500">Perbarui informasi profil dasar dan email korporat.</p>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Lengkap <span class="text-error-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @error('name') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email Korporat <span class="text-error-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @error('email') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Otoritas Departemen <span class="text-error-500">*</span>
                                </label>
                                <div class="relative z-20">
                                    <select name="role" required
                                        class="w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>ADMINISTRATOR (FULL ACCESS)</option>
                                        <option value="finance" {{ old('role', $user->role) === 'finance' ? 'selected' : '' }}>FINANCE (ECONOMIC OPS)</option>
                                        <option value="warehouse" {{ old('role', $user->role) === 'warehouse' ? 'selected' : '' }}>WAREHOUSE (LOGISTICS)</option>
                                        <option value="purchasing" {{ old('role', $user->role) === 'purchasing' ? 'selected' : '' }}>PURCHASING (PROCUREMENT)</option>
                                    </select>
                                    <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2 text-gray-500">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                </div>
                                @error('role') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Credentials Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] lg:p-8">
                        <div class="mb-6 border-b border-gray-100 pb-4 dark:border-gray-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ubah Password</h3>
                            <p class="text-sm text-gray-500">Biarkan kosong jika Anda tidak ingin mengubah password saat ini.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Password Baru
                                </label>
                                <input type="password" name="password" placeholder="••••••••"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @error('password') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" name="password_confirmation" placeholder="••••••••"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm outline-hidden transition focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Actions (1/3) -->
                <div class="space-y-6">
                    <!-- Action Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-4 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Otorisasi Akun</h3>
                        <div class="flex flex-col gap-4">
                            <button type="submit" 
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-brand-600 shadow-theme-xs">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12.75 3L15 5.25M14.25 1.5L16.5 3.75L6.75 13.5H4.5V11.25L14.25 1.5Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Commit Changes
                            </button>
                            <a href="{{ route('users.index') }}" 
                                class="flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3.5 text-sm font-bold text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:bg-white/[0.05]">
                                Batal
                            </a>
                        </div>
                    </div>

                    <!-- Status Info Card -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                        <h3 class="mb-3 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Informasi Status</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>Terdaftar Sejak:</span>
                                <span class="font-bold text-gray-700 dark:text-gray-300">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>Last Update:</span>
                                <span class="font-bold text-gray-700 dark:text-gray-300">{{ $user->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
