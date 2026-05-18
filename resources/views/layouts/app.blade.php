<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | PT Mesama Global Indonesia - ERP</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
                        'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                    }
                }
            });

            Alpine.store('sidebar', {
                // Initialize based on screen size
                isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // When toggling desktop sidebar, ensure mobile menu is closed
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    // Don't modify isExpanded when toggling mobile menu
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover effects on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    <!-- Apply dark mode immediately to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

</head>

<body
    class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100"
    x-data="{ 'loaded': true}"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);">

    {{-- preloader --}}
    <x-common.preloader />
    {{-- preloader end --}}

    <div class="min-h-screen xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 min-w-0 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- app header start -->
            @include('layouts.app-header')
            <!-- app header end -->
            <div class="px-4 py-2 mx-auto w-full max-w-full md:px-6 md:py-4">
                <!-- Global Toast Notifications (TailAdmin Style) -->
                <div 
                    x-data="{ 
                        toasts: [],
                        add(toast) {
                            toast.id = Date.now();
                            this.toasts.push(toast);
                            setTimeout(() => this.remove(toast.id), toast.duration || 5000);
                        },
                        remove(id) {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }
                    }"
                    @toast.window="add($event.detail)"
                    class="fixed right-4 top-4 z-99999 flex flex-col gap-4 w-full max-w-[400px]"
                >
                    <!-- Success Toast -->
                    @if (session('success'))
                        <div 
                            x-data="{ show: true }"
                            x-show="show"
                            x-init="setTimeout(() => show = false, 5000)"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-[20px]"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-[20px]"
                            class="flex w-full rounded-[10px] border-l-6 border-[#34D399] bg-white p-4 shadow-theme-lg dark:bg-[#1B1B24] items-start"
                        >
                            <div class="mr-4 flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-[10px] bg-[#34D399]">
                                <svg width="22" height="16" viewBox="0 0 22 16" fill="none"><path d="M1.5 8.5L7.5 14.5L20.5 1.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="w-full">
                                <h5 class="mb-0.5 text-base font-bold text-gray-900 dark:text-white leading-tight">Success Notification</h5>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    @endif

                    <!-- Error Notification (Manual Error) -->
                    @if (session('error'))
                        <div 
                            x-data="{ show: true }"
                            x-show="show"
                            x-init="setTimeout(() => show = false, 5000)"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-[20px]"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-[20px]"
                            class="flex w-full rounded-[10px] border-l-6 border-[#F87171] bg-white p-4 shadow-theme-lg dark:bg-[#1B1B24] items-start"
                        >
                            <div class="mr-4 flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-[10px] bg-[#F87171]">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="w-full">
                                <h5 class="mb-0.5 text-base font-bold text-gray-900 dark:text-white leading-tight">Gagal!</h5>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    @endif

                    <!-- Error Toast (Validation Errors) -->
                    @if ($errors->any())
                        <div 
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-[20px]"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-[20px]"
                            class="flex w-full rounded-[10px] border-l-6 border-[#F87171] bg-white p-4 shadow-theme-lg dark:bg-[#1B1B24] items-start"
                        >
                            <div class="mr-4 flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-[10px] bg-[#F87171]">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="w-full">
                                <h5 class="mb-0.5 text-base font-bold text-gray-900 dark:text-white leading-tight">Error Notification</h5>
                                <ul class="list-inside list-disc text-sm font-medium text-gray-500 dark:text-gray-400">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button @click="show = false" class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    @endif

                    <!-- Dynamic Toasts -->
                    <template x-for="toast in toasts" :key="toast.id">
                        <div 
                            x-show="true"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-[20px]"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-[20px]"
                            class="flex w-full rounded-[10px] border-l-6 p-4 shadow-theme-lg bg-white dark:bg-[#1B1B24] items-start"
                            :class="{
                                'border-[#34D399]': toast.type === 'success',
                                'border-[#F87171]': toast.type === 'error',
                                'border-[#F59E0B]': toast.type === 'warning',
                                'border-[#3B82F6]': toast.type === 'info'
                            }"
                        >
                            <div class="mr-4 flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-[10px]"
                                :class="{
                                    'bg-[#34D399]': toast.type === 'success',
                                    'bg-[#F87171]': toast.type === 'error',
                                    'bg-[#F59E0B]': toast.type === 'warning',
                                    'bg-[#3B82F6]': toast.type === 'info'
                                }">
                                <!-- Icons based on type -->
                                <svg x-show="toast.type === 'success'" width="22" height="16" viewBox="0 0 22 16" fill="none"><path d="M1.5 8.5L7.5 14.5L20.5 1.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg x-show="toast.type === 'error'" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg x-show="toast.type === 'warning'" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 5V11M10 15H10.01" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="w-full">
                                <h5 class="mb-0.5 text-base font-bold text-gray-900 dark:text-white leading-tight" x-text="toast.title"></h5>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400" x-text="toast.message"></p>
                            </div>
                            <button @click="remove(toast.id)" class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                @yield('content')
            </div>

            <!-- Global Confirmation Modal (TailAdmin Style) -->
            <div 
                x-data="{ 
                    show: false, 
                    title: '', 
                    message: '', 
                    confirmText: 'Konfirmasi',
                    cancelText: 'Batal',
                    type: 'danger', // danger, primary, success
                    onConfirm: null,
                    confirm(options) {
                        this.title = options.title || 'Konfirmasi';
                        this.message = options.message || 'Apakah Anda yakin?';
                        this.confirmText = options.confirmText || 'Konfirmasi';
                        this.cancelText = options.cancelText || 'Batal';
                        this.type = options.type || 'danger';
                        this.onConfirm = options.onConfirm;
                        this.show = true;
                    },
                    execute() {
                        if (this.onConfirm) this.onConfirm();
                        this.show = false;
                    }
                }"
                @confirm.window="confirm($event.detail)"
                x-show="show"
                class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm"
                x-cloak
            >
                <div 
                    @click.away="show = false"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="w-full max-w-[500px] rounded-[20px] bg-white px-8 py-10 text-center shadow-theme-lg dark:bg-gray-900 border border-gray-100 dark:border-gray-800"
                >
                    <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full"
                        :class="{
                            'bg-red-50 text-red-500 dark:bg-red-500/10': type === 'danger',
                            'bg-brand-50 text-brand-500 dark:bg-brand-500/10': type === 'primary',
                            'bg-green-50 text-green-500 dark:bg-green-500/10': type === 'success',
                            'bg-warning-50 text-warning-500 dark:bg-warning-500/10': type === 'warning'
                        }">
                        <svg x-show="type === 'danger'" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 12.5V22.5M20 27.5H20.0167M36.6667 20C36.6667 29.2047 29.2047 36.6667 20 36.6667C10.7953 36.6667 3.33333 29.2047 3.33333 20C3.33333 10.7953 10.7953 3.33333 20 3.33333C29.2047 3.33333 36.6667 10.7953 36.6667 20Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg x-show="type === 'primary'" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16V12M12 8H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg x-show="type === 'success'" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg x-show="type === 'warning'" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="12" y1="9" x2="12" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    
                    <h3 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white" x-text="title"></h3>
                    <p class="mb-10 text-base text-gray-500 dark:text-gray-400" x-text="message"></p>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="w-full sm:flex-1">
                            <button @click="show = false" class="block w-full rounded-lg border border-gray-300 bg-white px-5 py-3 text-center text-base font-medium text-gray-700 transition hover:border-gray-400 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700" x-text="cancelText"></button>
                        </div>
                        <div class="w-full sm:flex-1">
                            <button @click="execute()" 
                                :class="{
                                    'bg-red-500 hover:bg-red-600': type === 'danger',
                                    'bg-brand-500 hover:bg-brand-600': type === 'primary',
                                    'bg-green-500 hover:bg-green-600': type === 'success',
                                    'bg-warning-500 hover:bg-warning-600': type === 'warning'
                                }"
                                class="block w-full rounded-lg px-5 py-3 text-center text-base font-medium text-white transition shadow-theme-xs" x-text="confirmText"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

@stack('scripts')

</html>