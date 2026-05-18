@extends('layouts.fullscreen-layout')

@section('content')
    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
        <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">
            <!-- Form -->
            <div class="flex w-full flex-1 flex-col items-center justify-center">
                <div class="mx-auto w-full max-w-md px-6">
                    <div class="mb-8 text-center">
                        <a href="/" class="inline-flex items-center justify-center mb-6">
                            <!-- Icon Logo -->
                            <div class="flex items-center justify-center min-w-12 min-h-12 w-12 h-12 rounded-xl bg-brand-500 text-white font-bold text-3xl leading-none">
                                M
                            </div>
                        </a>
                        <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                            Lupa Password?
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Tidak masalah. Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
                        </p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 rounded-lg bg-success-50 p-4 text-sm text-success-700 border border-success-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email<span class="text-error-500">*</span>
                                </label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Masukkan email Anda"
                                    required autofocus
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('email') border-error-500 @enderror" />
                                @error('email')
                                    <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <button type="submit"
                                    class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                                    Kirim Link Reset Password
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-5 text-center">
                        <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 dark:text-brand-400 text-sm">
                            &larr; Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dark Mode Toggler -->
            <div class="fixed right-6 bottom-6 z-50">
                <button
                    class="bg-brand-500 hover:bg-brand-600 flex h-12 w-12 items-center justify-center rounded-full text-white shadow-lg transition-colors"
                    @click.prevent="$store.theme.toggle()">
                    <!-- Sun Icon (visible in dark mode) -->
                    <svg class="hidden dark:block" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3V4M12 20V21M4 12H3M21 12H20M18.364 5.63604L17.6569 6.34315M6.34315 17.6569L5.63604 18.364M18.364 18.364L17.6569 17.6569M6.34315 6.34315L5.63604 5.63604M12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <!-- Moon Icon (visible in light mode) -->
                    <svg class="dark:hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection
