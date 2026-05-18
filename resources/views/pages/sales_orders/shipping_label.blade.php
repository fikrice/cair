@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-4 pb-12">
    <!-- Modern Header Navigation -->
    <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-emerald-500 to-teal-700 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                <i data-lucide="truck" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight leading-none uppercase">Shipping Label</h2>
                <p class="text-xs text-gray-400 font-medium mt-1">Status: <span class="text-blue-500 font-bold uppercase tracking-widest">Logistics Preview</span></p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button disabled class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-6 py-3 text-xs font-black text-gray-400 cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                <i data-lucide="download-cloud" class="w-4 h-4"></i>
                PDF
            </button>
            <button disabled class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-6 py-3 text-xs font-black text-gray-400 cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                <i data-lucide="printer" class="w-4 h-4"></i>
                PRINT
            </button>
            <a href="{{ route('sales-orders.show', $salesOrder) }}" class="inline-flex items-center gap-2 rounded-xl bg-white border border-gray-200 px-6 py-3 text-xs font-black text-gray-600 hover:bg-gray-50 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 active:scale-95">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                BACK
            </a>
        </div>
    </div>

    <!-- Eye-Catching Modern Shipping Label -->
    <div class="bg-white dark:bg-gray-900 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] rounded-[3rem] overflow-hidden border-4 border-dashed border-blue-600/30 dark:border-blue-500/20 relative p-8 sm:p-12">
        
        <div id="label-content" class="relative bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 sm:p-16 border border-gray-100 dark:border-gray-700 shadow-2xl">
            
            <!-- Dynamic Background Element -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600 rounded-bl-[200px] -mr-10 -mt-10 flex items-center justify-center pl-10 pb-10 shadow-2xl">
                <div class="text-white text-center">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-1 opacity-60 font-mono italic">Logistics Code</p>
                    <p class="text-3xl font-black font-mono tracking-tighter leading-none">{{ substr($salesOrder->so_number, -4) }}</p>
                </div>
            </div>

            <!-- Branding Header -->
            <div class="flex items-center gap-6 mb-16 relative z-10 border-b-4 border-gray-50 dark:border-gray-700 pb-10">
                <div class="w-24 h-24 bg-gradient-to-tr from-gray-900 to-blue-900 rounded-[2.5rem] flex items-center justify-center text-white font-black text-5xl shadow-2xl shadow-blue-100 ring-8 ring-white dark:ring-gray-800">M</div>
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter uppercase leading-none">PT MESAMA GLOBAL</h1>
                    <p class="text-sm font-bold text-blue-600 tracking-[0.5em] uppercase mt-3 italic">Authorized Shipping Label</p>
                </div>
            </div>

            <!-- Shipping Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 mb-16 relative z-10">
                <!-- Large Recipient Card -->
                <div class="lg:col-span-3 bg-blue-600 rounded-[4rem] p-12 text-white shadow-[0_30px_70px_-15px_rgba(37,99,235,0.4)] relative overflow-hidden group transition-all hover:scale-[1.01]">
                    <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-3xl opacity-50 group-hover:scale-125 transition-transform duration-700"></div>
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i data-lucide="map-pin" class="w-5 h-5 text-white"></i>
                        </div>
                        <h3 class="text-[11px] font-black uppercase tracking-[0.3em] opacity-80 leading-none italic font-mono">Deliver To Destination:</h3>
                    </div>

                    <h2 class="text-6xl font-black mb-4 tracking-tighter uppercase leading-none">{{ $salesOrder->customer_name }}</h2>
                    <p class="text-2xl font-bold text-blue-100 mb-10 font-mono tracking-widest">{{ $salesOrder->customer_phone ?: 'CONTACT INFO HIDDEN' }}</p>
                    
                    <div class="bg-white/10 rounded-[2.5rem] p-10 border border-white/20 backdrop-blur-md shadow-inner">
                        <p class="text-xl italic leading-relaxed font-bold text-blue-50">
                            {{ $salesOrder->shipping_address ?: 'Recipient shipping address is not configured for this order.' }}
                        </p>
                    </div>
                </div>

                <!-- Logistics & Sender Info -->
                <div class="lg:col-span-2 flex flex-col justify-between py-6">
                    <div class="space-y-12">
                        <div>
                            <div class="flex items-center gap-3 mb-6 text-gray-400">
                                <i data-lucide="package" class="w-5 h-5 text-blue-600"></i>
                                <h3 class="text-[11px] font-black uppercase tracking-[0.3em] font-mono leading-none">Shipping Hub:</h3>
                            </div>
                            <p class="text-2xl font-black text-gray-900 dark:text-white leading-none mb-2">STOCKSSELL HUB CENTER</p>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest italic">Managed by PT Mesama Global Indonesia</p>
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 mt-6 leading-relaxed italic font-bold max-w-xs">
                                Kawasan Industri Jababeka, Blok C-14, Warehouse A1-2, Cikarang, Jawa Barat
                            </p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700/50 p-8 rounded-[3rem] border border-gray-100 dark:border-gray-700 border-dashed">
                            <p class="text-[11px] font-black text-gray-400 uppercase mb-4 font-mono flex items-center gap-2 italic">
                                <span class="w-2 h-2 bg-blue-600 rounded-full"></span> Tracking Info:
                            </p>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 leading-none">ORDER ID:</p>
                                    <p class="text-2xl font-black text-blue-600 font-mono tracking-tighter italic leading-none">{{ $salesOrder->so_number }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 leading-none font-mono">SHIP DATE:</p>
                                    <p class="text-sm font-black text-gray-900 dark:text-white italic underline underline-offset-8 decoration-blue-200">{{ now()->format('d.m.Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Detail (Industry standard table-less cards) -->
            <div class="bg-gray-900 rounded-[4rem] p-12 text-white relative overflow-hidden shadow-2xl mb-16">
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-blue-600 opacity-5 rounded-full blur-3xl"></div>
                <div class="flex items-center justify-between mb-10 border-b border-white/10 pb-8">
                    <div class="flex items-center gap-4">
                        <i data-lucide="layers" class="w-6 h-6 text-blue-400"></i>
                        <h3 class="text-lg font-black uppercase tracking-[0.2em] italic">Package Manifest</h3>
                    </div>
                    <span class="bg-blue-600 text-white px-6 py-2 rounded-full text-xs font-black tracking-widest">CONTENTS: {{ count($salesOrder->items) }} ITEMS</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($salesOrder->items as $item)
                    <div class="bg-white/5 border border-white/10 p-6 rounded-[2rem] flex justify-between items-center transition-all hover:bg-white/10 group">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-2 bg-blue-500 rounded-full group-hover:scale-150 transition-transform duration-300"></div>
                            <div>
                                <p class="font-black text-white uppercase text-sm tracking-tight leading-none mb-1">{{ $item->product->name }}</p>
                                <p class="text-[10px] text-gray-500 font-mono italic tracking-widest uppercase leading-none">{{ $item->product->sku }}</p>
                            </div>
                        </div>
                        <div class="text-right bg-white/10 px-4 py-2 rounded-2xl">
                            <span class="text-2xl font-black text-blue-400 leading-none">{{ $item->quantity }}</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">{{ $item->product->unit ?: 'pcs' }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Verification & Security -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 pt-10 border-t-4 border-dotted border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-8 bg-gray-50 dark:bg-gray-800/50 rounded-[3rem] p-10 border border-gray-100 dark:border-gray-700">
                    <div class="w-28 h-28 bg-white dark:bg-gray-900 rounded-[2rem] flex items-center justify-center border-2 border-gray-100 dark:border-gray-800 shadow-inner group">
                        <i data-lucide="qr-code" class="w-16 h-16 text-gray-200 group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-black text-gray-900 dark:text-white uppercase tracking-[0.5em] leading-none mb-2 font-mono">Digital ID</p>
                        <p class="text-[10px] text-gray-400 font-bold italic leading-relaxed tracking-tight">Verified by Mesama Logistics Global Authentication Protocol.</p>
                        <div class="flex gap-2 mt-4">
                            <div class="w-6 h-1 bg-blue-600 rounded-full"></div>
                            <div class="w-6 h-1 bg-emerald-500 rounded-full"></div>
                            <div class="w-6 h-1 bg-gray-300 rounded-full"></div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center md:items-end text-center md:text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 italic">Recipient Confirmation:</p>
                    <div class="border-b-2 border-gray-200 dark:border-gray-700 w-full sm:w-64 mb-4"></div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest italic opacity-50 font-mono">Official Signature & Date</p>
                </div>
            </div>

            <!-- Branding Footer -->
            <div class="mt-16 pt-8 text-center border-t border-gray-50 dark:border-gray-700">
                <p class="text-[9px] text-gray-300 font-black uppercase tracking-[1em]">LOGISTICS EXCELLENCE BY MESAMA GLOBAL</p>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
