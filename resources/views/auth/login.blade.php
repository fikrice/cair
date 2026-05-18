@extends('layouts.fullscreen-layout')

@section('content')
    <div class="relative z-1 bg-white dark:bg-gray-900">
        <div class="relative flex h-screen w-full flex-col lg:flex-row">
            
            <!-- Left Side: Login Form -->
            <div class="flex w-full flex-1 flex-col bg-white px-6 py-10 dark:bg-gray-900 lg:w-1/2 lg:px-12">
                <!-- Navigation -->
                <div class="mx-auto w-full max-w-md">
                    <a href="{{ route('dashboard') }}"
                        class="group inline-flex items-center text-sm font-medium text-gray-500 transition-colors hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400">
                        <svg class="mr-2 transition-transform group-hover:-translate-x-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="M12.5 15L7.5 10L12.5 5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>

                <!-- Form Content -->
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div class="mb-10">
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Selamat Datang Kembali <span class="text-brand-500">.</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                            Kelola operasional bisnis Anda dengan lebih cerdas, efisien, dan terintegrasi dalam satu platform.
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="mb-6 rounded-xl bg-green-50 p-4 text-sm font-medium text-green-700 border border-green-100 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <!-- Email -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@mesama.com"
                                required autofocus
                                class="h-12 w-full rounded-xl border border-gray-300 bg-gray-50 px-4 text-sm transition-all focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('email') border-error-500 @enderror" />
                            @error('email')
                                <p class="mt-2 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                            </div>
                            <div x-data="{ showPassword: false }" class="relative">
                                <input :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Masukkan password Anda"
                                    required
                                    class="h-12 w-full rounded-xl border border-gray-300 bg-gray-50 px-4 pr-12 text-sm transition-all focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('password') border-error-500 @enderror" />
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-500">
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Button -->
                        <button type="submit"
                            class="flex w-full items-center justify-center rounded-xl bg-brand-600 px-4 py-4 text-sm font-bold text-white shadow-lg shadow-brand-500/20 transition-all hover:bg-brand-700 hover:shadow-brand-500/40 active:scale-[0.98]">
                            Masuk ke Sistem
                        </button>
                    </form>

                    <div class="mt-8 border-t border-gray-100 pt-8 dark:border-gray-800">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Kendala akses? <a href="#" class="font-semibold text-brand-600 hover:underline">Hubungi IT Support</a> untuk bantuan pemulihan akun.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Brand Showcase -->
            <div class="relative hidden w-1/2 flex-col items-center justify-center overflow-hidden bg-brand-950 lg:flex dark:bg-black">
                <!-- Background Pattern/Elements -->
                <div class="absolute inset-0 opacity-20">
                    <x-common.common-grid-shape />
                </div>
                <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full bg-brand-500/20 blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 h-80 w-80 rounded-full bg-brand-700/20 blur-3xl"></div>

                <!-- Glass Card -->
                <div class="z-10 w-full max-w-lg px-8">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-10 backdrop-blur-xl">
                        <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500 text-white shadow-xl shadow-brand-500/50">
                            <span class="text-3xl font-black italic">M</span>
                        </div>
                        
                        <h2 class="mb-4 text-4xl font-bold leading-tight text-white">
                            The Next Level of <br/>
                            <span class="text-brand-400">Enterprise Resource</span> Planning.
                        </h2>
                        
                        <p class="mb-8 text-lg text-gray-300 leading-relaxed">
                            Membangun masa depan industri bersama <strong>PT Mesama Global Indonesia</strong> melalui integrasi data yang presisi.
                        </p>

                        <!-- Social Proof / Features -->
                        <div class="grid grid-cols-2 gap-4 border-t border-white/10 pt-8">
                            <div>
                                <p class="text-2xl font-bold text-white">Real-time</p>
                                <p class="text-sm text-gray-400">Monitoring Data</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-white">Secure</p>
                                <p class="text-sm text-gray-400">Enterprise Grade</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Info -->
                <div class="absolute bottom-10 text-sm text-gray-500">
                    © {{ date('Y') }} PT Mesama Global Indonesia. All rights reserved.
                </div>
            </div>

            <!-- Dark Mode Toggler -->
            <div class="fixed right-6 bottom-6 z-50">
                <button
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-800 shadow-xl ring-1 ring-gray-200 transition-all hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:ring-gray-700"
                    @click.prevent="$store.theme.toggle()">
                    <svg class="hidden dark:block" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3V4M12 20V21M4 12H3M21 12H20M18.364 5.636L17.657 6.343M6.343 17.657L5.636 18.364M18.364 18.364L17.657 17.657M6.343 6.343L5.636 5.636M12 8C9.79 8 8 9.79 8 12s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <svg class="dark:hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>
    </div>
@endsection