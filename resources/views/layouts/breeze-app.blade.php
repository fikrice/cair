<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'StockSell') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{ page: 'ecommerce', loaded: true, darkMode: false, sidebarToggle: false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false')"
    :class="{ 'dark bg-gray-900': darkMode === true }"
>
    <div class="flex h-screen overflow-hidden">
        @include('layouts.sidebar')

        <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
            @include('layouts.app-header')

            <main>
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
