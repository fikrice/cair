@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-4 pb-12">
    <!-- Modern Header Navigation -->
    <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-gray-900 to-slate-700 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-gray-200">
                <i data-lucide="shopping-bag" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight leading-none uppercase">Purchase Order</h2>
                <p class="text-xs text-gray-400 font-medium mt-1">Status: <span class="text-indigo-500 font-bold uppercase tracking-widest">Procurement Preview</span></p>
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
            <a href="{{ route('purchase-orders.show', $purchaseOrder) }}" class="inline-flex items-center gap-2 rounded-xl bg-white border border-gray-200 px-6 py-3 text-xs font-black text-gray-600 hover:bg-gray-50 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 active:scale-95">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                BACK
            </a>
        </div>
    </div>

    <!-- Eye-Catching Modern Purchase Order -->
    <div class="bg-white dark:bg-gray-900 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] rounded-[3rem] overflow-hidden border border-gray-100 dark:border-gray-800 relative transition-all hover:shadow-2xl">
        
        <!-- Top Authority Bar -->
        <div class="h-3 bg-gradient-to-r from-gray-900 via-blue-900 to-indigo-900"></div>

        <div id="po-content" class="relative">
            
            <!-- Corporate Header (Prestige Mode) -->
            <div class="bg-gray-900 p-10 sm:p-16 text-white flex flex-col lg:flex-row justify-between items-start gap-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-full h-full bg-blue-600 opacity-5 -skew-x-12 translate-x-1/2"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-16 h-16 bg-blue-600 rounded-[2rem] flex items-center justify-center text-white font-black text-4xl shadow-2xl shadow-blue-500/20 ring-4 ring-white/10">M</div>
                        <div>
                            <h1 class="text-2xl font-black text-white tracking-tighter uppercase leading-none">PT MESAMA GLOBAL</h1>
                            <p class="text-[10px] font-bold text-blue-400 tracking-[0.4em] uppercase mt-2 italic leading-none">Procurement & Supply Chain</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-[11px] text-gray-400 font-bold max-w-sm leading-relaxed">
                        <p class="flex items-center gap-3"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-500"></i> Jl. Jendral Sudirman No. 123, SCBD, Jakarta Selatan</p>
                        <p class="flex items-center gap-3"><i data-lucide="globe" class="w-3.5 h-3.5 text-blue-500"></i> purchasing@mesamaglobal.com | (021) 555-0192</p>
                    </div>
                </div>
                <div class="text-left lg:text-right relative z-10 flex flex-col justify-end items-start lg:items-end">
                    <div class="bg-white/5 backdrop-blur-md p-8 rounded-[3rem] border border-white/10 shadow-2xl">
                        <h2 class="text-5xl font-black text-white/5 uppercase tracking-tighter leading-none mb-4 select-none">ORDER</h2>
                        <div class="flex flex-col gap-2">
                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest font-mono">PURCHASE ORDER NO:</p>
                            <p class="text-4xl font-black text-white tracking-tighter leading-none font-mono italic">{{ $purchaseOrder->po_number }}</p>
                            <div class="h-1.5 w-16 bg-blue-600 rounded-full lg:ml-auto mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 sm:p-16">
                <!-- Info Cards (Modern UI) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
                    <div class="group bg-gray-50 dark:bg-gray-800/50 rounded-[3.5rem] p-10 border border-gray-100 dark:border-gray-700 transition-all hover:bg-gray-100/50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                            <i data-lucide="truck" class="w-5 h-5 text-blue-600"></i> OFFICIAL VENDOR:
                        </p>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-2 tracking-tighter uppercase leading-none">{{ $purchaseOrder->supplier->name }}</h3>
                        <p class="text-sm font-bold text-blue-600 mb-6 tracking-widest font-mono italic uppercase">ID: {{ $purchaseOrder->supplier->code }}</p>
                        <div class="h-0.5 w-full bg-gray-200 dark:bg-gray-700 mb-6 border-dashed"></div>
                        <p class="text-[13px] text-gray-500 dark:text-gray-400 italic leading-relaxed font-bold">
                            {{ $purchaseOrder->supplier->address }}, {{ $purchaseOrder->supplier->city }}
                        </p>
                    </div>
                    
                    <div class="flex flex-col justify-between py-6 px-4">
                        <div class="grid grid-cols-2 gap-10 mb-10">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">ORDER DATE:</p>
                                <p class="text-base font-black text-gray-900 dark:text-white leading-none">{{ $purchaseOrder->po_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">EXPECTED ARRIVAL:</p>
                                <p class="text-base font-black text-blue-600 leading-none underline decoration-blue-200 decoration-4 underline-offset-4">{{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('d M Y') : 'URGENT' }}</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-[2.5rem] p-8 border border-blue-100 dark:border-blue-800/50">
                            <p class="text-[10px] font-black text-blue-600 uppercase mb-3 flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4"></i> DELIVERY DESTINATION:
                            </p>
                            <p class="text-[11px] font-bold text-gray-700 dark:text-gray-300 leading-relaxed uppercase tracking-tight">
                                <span class="text-gray-900 dark:text-white font-black">PT MESAMA GLOBAL - MAIN WAREHOUSE</span><br>
                                Kawasan Industri Jababeka, Blok C-14, Cikarang<br>
                                PIC: Hub Manager (+62 812-3456-7890)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Items Table (Industry Standard) -->
                <div class="mb-16">
                    <div class="overflow-hidden rounded-[3rem] border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-900 text-white">
                                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-[0.2em] w-16 text-center">#</th>
                                    <th class="py-6 px-4 text-[10px] font-black uppercase tracking-[0.2em]">Item Specification</th>
                                    <th class="py-6 px-4 text-[10px] font-black uppercase tracking-[0.2em] text-center">Qty</th>
                                    <th class="py-6 px-4 text-[10px] font-black uppercase tracking-[0.2em] text-right">Unit Rate</th>
                                    <th class="py-6 px-10 text-[10px] font-black uppercase tracking-[0.2em] text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                @foreach($purchaseOrder->items as $index => $item)
                                <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="py-8 px-8 text-gray-300 font-bold italic text-center text-sm leading-none">{{ $index + 1 }}</td>
                                    <td class="py-8 px-4">
                                        <p class="font-black text-gray-900 dark:text-white uppercase text-base tracking-tighter leading-none mb-1">{{ $item->product->name }}</p>
                                        <p class="text-[9px] text-blue-600 font-bold font-mono tracking-widest uppercase">{{ $item->product->sku }}</p>
                                    </td>
                                    <td class="py-8 px-4 text-center">
                                        <span class="bg-gray-900 text-white px-5 py-1.5 rounded-2xl text-[11px] font-black shadow-lg">
                                            {{ $item->quantity }} <span class="text-[9px] opacity-50 uppercase ml-1 tracking-widest">{{ $item->product->unit ?: 'pcs' }}</span>
                                        </span>
                                    </td>
                                    <td class="py-8 px-4 text-right font-bold text-gray-400 italic">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="py-8 px-10 text-right font-black text-gray-900 dark:text-white text-lg tracking-tighter">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer Budget Summary -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="flex flex-col justify-center">
                        <div class="bg-gray-900 rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-600 opacity-20 rounded-full blur-3xl"></div>
                            <h4 class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-4 italic leading-none">Official Terms & Conditions:</h4>
                            <p class="text-[11px] text-gray-400 leading-relaxed font-medium">
                                {{ $purchaseOrder->notes ?: 'All items must meet quality standards. Please provide invoice and delivery note upon arrival. Payment will be processed according to corporate agreement.' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="space-y-4 p-4">
                            <div class="flex justify-between items-center text-sm font-bold text-gray-400">
                                <span class="uppercase tracking-widest text-[10px]">Net Purchase Amount</span>
                                <span class="text-gray-900 dark:text-white">Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-bold text-gray-400 pb-4 border-b-2 border-gray-100 dark:border-gray-800 border-dashed">
                                <span class="uppercase tracking-widest text-[10px]">Adjustments / Tax</span>
                                <span class="text-emerald-500 italic">No tax applied</span>
                            </div>
                            <div class="flex justify-between items-center pt-6">
                                <div>
                                    <span class="text-[10px] font-black text-gray-900 dark:text-white uppercase tracking-[0.4em]">GRAND TOTAL</span>
                                    <p class="text-[9px] text-blue-500 font-bold uppercase mt-1 italic tracking-widest">Budget allocated</p>
                                </div>
                                <span class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter leading-none ring-offset-8 ring-4 ring-blue-600/10 rounded-xl px-2">Rp {{ number_format($purchaseOrder->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Signature Grid -->
                <div class="mt-24 pt-16 border-t-2 border-gray-50 dark:border-gray-800 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-20 italic">AUTHORIZED PROCUREMENT</p>
                        <div class="flex flex-col items-center">
                            <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight mb-2">{{ $purchaseOrder->creator->name }}</p>
                            <div class="h-1 w-12 bg-blue-600 rounded-full"></div>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-20 italic">VALIDATED BY HUB</p>
                        <div class="border-b-2 border-gray-100 dark:border-gray-700 mx-auto w-32 border-dashed"></div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-20 italic">VENDOR ACCEPTANCE</p>
                        <div class="border-b-2 border-gray-100 dark:border-gray-700 mx-auto w-32 border-dashed"></div>
                    </div>
                </div>
            </div>
            
            <!-- Corporate Footer -->
            <div class="bg-gray-900 p-10 text-center">
                <p class="text-[9px] text-gray-500 font-black uppercase tracking-[1em] leading-none italic">PT MESAMA GLOBAL INDONESIA | PROCUREMENT EXCELLENCE</p>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
