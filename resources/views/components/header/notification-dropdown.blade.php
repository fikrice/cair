{{-- Notification Dropdown Component --}}
<div class="relative" x-data="{
    dropdownOpen: false,
    notifying: true,
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
        this.notifying = false;
    },
    closeDropdown() {
        this.dropdownOpen = false;
    },
    handleItemClick() {
        console.log('Notification item clicked');
        this.closeDropdown();
    },
    handleViewAllClick() {
        console.log('View All Notifications clicked');
        this.closeDropdown();
    }
}" @click.away="closeDropdown()">
    <!-- Notification Button -->
    <button
        class="relative flex items-center justify-center text-gray-500 transition-colors bg-white border border-gray-200 rounded-full hover:text-dark-900 h-11 w-11 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        @click="toggleDropdown()"
        type="button"
    >
        <!-- Notification Badge -->
        <span
            x-show="notifying"
            class="absolute right-0 top-0.5 z-1 h-2 w-2 rounded-full bg-orange-400"
        >
            <span
                class="absolute inline-flex w-full h-full bg-orange-400 rounded-full opacity-75 -z-1 animate-ping"
            ></span>
        </span>

        <!-- Bell Icon -->
        <svg
            class="fill-current"
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z"
                fill=""
            />
        </svg>
    </button>

    <!-- Dropdown Start -->
    <div
        x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
        class="absolute -right-16 mt-4 flex h-auto max-h-[480px] w-80 flex-col rounded-2xl border border-gray-200 bg-white shadow-theme-lg z-50 dark:border-gray-800 dark:bg-gray-900 sm:right-0 sm:w-96"
        style="display: none;"
    >
        <!-- Dropdown Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h5 class="text-lg font-bold text-gray-900 dark:text-white">Notifikasi</h5>
            <span class="rounded-full bg-brand-500 px-2 py-0.5 text-xs font-bold text-white">4 Baru</span>
        </div>

        <!-- Notification List -->
        <div class="overflow-y-auto custom-scrollbar flex-1">
            <ul class="flex flex-col">
                @php
                    $notifications = [
                        [
                            'id' => 1,
                            'title' => 'Stok Menipis!',
                            'message' => 'Produk "Sunscreen SPF 50" sisa 5 unit.',
                            'time' => '10 Menit lalu',
                            'type' => 'warning',
                        ],
                        [
                            'id' => 2,
                            'title' => 'Pesanan Baru',
                            'message' => 'PO #2024001 telah diterima dari supplier.',
                            'time' => '1 Jam lalu',
                            'type' => 'success',
                        ],
                        [
                            'id' => 3,
                            'title' => 'Pembayaran Berhasil',
                            'message' => 'Invoice #INV-9902 telah dilunasi.',
                            'time' => '3 Jam lalu',
                            'type' => 'info',
                        ],
                        [
                            'id' => 4,
                            'title' => 'Gagal Sinkronisasi',
                            'message' => 'Gagal menghubungkan ke server pusat.',
                            'time' => '5 Jam lalu',
                            'type' => 'error',
                        ],
                    ];
                @endphp

                @foreach ($notifications as $notification)
                    <li>
                        <a href="#" class="flex gap-4 px-6 py-4 transition hover:bg-gray-50 dark:hover:bg-white/[0.03] border-b border-gray-50 dark:border-gray-800 last:border-0">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full 
                                {{ $notification['type'] === 'warning' ? 'bg-orange-50 text-orange-500 dark:bg-orange-500/10' : '' }}
                                {{ $notification['type'] === 'success' ? 'bg-green-50 text-green-500 dark:bg-green-500/10' : '' }}
                                {{ $notification['type'] === 'error' ? 'bg-red-50 text-red-500 dark:bg-red-500/10' : '' }}
                                {{ $notification['type'] === 'info' ? 'bg-blue-50 text-blue-500 dark:bg-blue-500/10' : '' }}
                            ">
                                @if($notification['type'] === 'warning')
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 6V10M10 14H10.01M18.3333 10C18.3333 14.6024 14.6024 18.3333 10 18.3333C5.39763 18.3333 1.66667 14.6024 1.66667 10C1.66667 5.39763 5.39763 1.66667 10 1.66667C14.6024 1.66667 18.3333 5.39763 18.3333 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @elseif($notification['type'] === 'success')
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M16.6666 5L7.49992 14.1667L3.33325 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @elseif($notification['type'] === 'error')
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 18.3333C14.6024 18.3333 18.3333 14.6024 18.3333 10C18.3333 5.39763 14.6024 1.66667 10 1.66667C5.39763 1.66667 1.66667 5.39763 1.66667 10C1.66667 14.6024 5.39763 18.3333 10 18.3333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 6V10L12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h6 class="text-sm font-bold text-gray-900 dark:text-white">{{ $notification['title'] }}</h6>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $notification['message'] }}</p>
                                <span class="mt-1.5 block text-[10px] font-medium text-gray-400 uppercase">{{ $notification['time'] }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- View All Button -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-800">
            <a href="#" class="flex items-center justify-center rounded-lg bg-gray-50 px-4 py-2.5 text-sm font-bold text-gray-700 transition hover:bg-gray-100 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]">
                Lihat Semua Notifikasi
            </a>
        </div>
    </div>
    <!-- Dropdown End -->
</div>
