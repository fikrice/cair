@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-4 pb-12">
    <!-- Modern Header Navigation -->
    <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i data-lucide="receipt-text" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight leading-none uppercase">Sales Invoice</h2>
                <p class="text-xs text-gray-400 font-medium mt-1">Status: <span class="text-emerald-500 font-bold uppercase tracking-widest">Verified Preview</span></p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="hidden sm:flex flex-col text-right mr-4">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Fitur Download & Cetak</p>
                <p class="text-[10px] font-bold text-amber-500 italic uppercase">Maintenance Mode</p>
            </div>
            <button disabled class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-6 py-3 text-xs font-black text-gray-400 cursor-not-allowed dark:bg-gray-700 dark:text-gray-500 transition-all border border-transparent">
                <i data-lucide="download-cloud" class="w-4 h-4"></i>
                PDF
            </button>
            <button disabled class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-6 py-3 text-xs font-black text-gray-400 cursor-not-allowed dark:bg-gray-700 dark:text-gray-500 transition-all border border-transparent">
                <i data-lucide="printer" class="w-4 h-4"></i>
                PRINT
            </button>
            <a href="{{ route('sales-orders.show', $salesOrder) }}" class="inline-flex items-center gap-2 rounded-xl bg-white border border-gray-200 px-6 py-3 text-xs font-black text-gray-600 hover:bg-gray-50 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 active:scale-95">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                BACK
            </a>
        </div>
    </div>

    <!-- Eye-Catching Modern Invoice -->
    <div class="bg-white dark:bg-gray-900 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] rounded-[3rem] overflow-hidden border border-gray-100 dark:border-gray-800 relative transition-all hover:shadow-2xl">
        
        <!-- Top Gradient Bar -->
        <div class="h-3 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-500"></div>

        <div id="invoice-content" class="p-8 sm:p-16 relative">
            
            <!-- Branding Section (Asymmetric) -->
            <div class="flex flex-col lg:flex-row justify-between gap-12 mb-20">
                <div class="flex-1">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 bg-[#0f172a] rounded-[2rem] flex items-center justify-center text-white font-black text-4xl shadow-2xl shadow-blue-100">M</div>
                        <div>
                            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter uppercase leading-none">PT MESAMA GLOBAL</h1>
                            <p class="text-[10px] font-bold text-blue-600 tracking-[0.4em] uppercase mt-2 italic">Logistics & Supply Chain</p>
                        </div>
                    </div>
                    <div class="space-y-1 text-xs text-gray-400 font-bold max-w-sm">
                        <p class="flex items-center gap-2"><i data-lucide="map-pin" class="w-3 h-3"></i> Jl. Jendral Sudirman No. 123, SCBD, Jakarta Selatan</p>
                        <p class="flex items-center gap-2"><i data-lucide="mail" class="w-3 h-3"></i> billing@mesamaglobal.com | (021) 555-0192</p>
                    </div>
                </div>
                <div class="flex-shrink-0 lg:text-right flex flex-col justify-end items-start lg:items-end">
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-[2.5rem] border border-gray-100 dark:border-gray-700">
                        <h2 class="text-6xl font-black text-gray-900/5 dark:text-white/5 uppercase tracking-tighter leading-none mb-2 select-none">INVOICE</h2>
                        <div class="flex flex-col gap-1">
                            <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest font-mono italic">{{ $salesOrder->so_number }}</p>
                            <div class="h-1 w-12 bg-blue-600 rounded-full ml-auto hidden lg:block"></div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mt-2">{{ $salesOrder->so_date->format('d F, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Cards (Modern UI) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <div class="group bg-blue-600 rounded-[3rem] p-10 text-white shadow-2xl shadow-blue-100 relative overflow-hidden transition-all hover:scale-[1.02]">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <p class="text-[10px] font-black text-blue-200 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4"></i> BILLED TO CUSTOMER
                    </p>
                    <h3 class="text-3xl font-black mb-1 tracking-tight uppercase">{{ $salesOrder->customer_name }}</h3>
                    <p class="text-sm font-bold text-blue-100 mb-6 font-mono">{{ $salesOrder->customer_phone ?: 'NO CONTACT INFO' }}</p>
                    <div class="bg-white/10 rounded-3xl p-6 border border-white/10 italic text-[13px] leading-relaxed font-medium">
                        {{ $salesOrder->shipping_address ?: 'No shipping address provided.' }}
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-[3rem] p-10 border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <i data-lucide="credit-card" class="w-4 h-4"></i> PAYMENT METHOD
                        </p>
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 bg-white dark:bg-gray-900 rounded-2xl flex items-center justify-center shadow-xl border border-gray-100 dark:border-gray-700">
                                <span class="font-black text-blue-600 text-xl italic tracking-tighter">BCA</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tight">Virtual Account</p>
                                <p class="text-xl font-mono font-black text-gray-900 dark:text-white tracking-[0.1em]">1234.5678.90</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700 mt-6">
                        <p class="text-[10px] font-black text-emerald-500 uppercase flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            A/N PT Mesama Global Indonesia
                        </p>
                    </div>
                </div>
            </div>

            <!-- Items Table (Industry Standard) -->
            <div class="mb-16">
                <div class="overflow-hidden rounded-[2.5rem] border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800/50 shadow-sm">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th class="py-6 px-8 text-[10px] font-black uppercase tracking-[0.2em]">Product / Services</th>
                                <th class="py-6 px-4 text-[10px] font-black uppercase tracking-[0.2em] text-center">Qty</th>
                                <th class="py-6 px-4 text-[10px] font-black uppercase tracking-[0.2em] text-right">Rate</th>
                                <th class="py-6 px-10 text-[10px] font-black uppercase tracking-[0.2em] text-right">Total (IDR)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach($salesOrder->items as $item)
                            <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="py-8 px-8">
                                    <p class="font-black text-gray-900 dark:text-white uppercase text-base tracking-tighter leading-none mb-1">{{ $item->product->name }}</p>
                                    <p class="text-[9px] text-blue-600 font-bold font-mono tracking-widest uppercase">{{ $item->product->sku }}</p>
                                </td>
                                <td class="py-8 px-4 text-center">
                                    <span class="bg-blue-600 text-white px-4 py-1 rounded-full text-xs font-black shadow-lg shadow-blue-100">
                                        {{ $item->quantity }} <span class="text-[9px] opacity-60 uppercase ml-1 tracking-widest">{{ $item->product->unit ?: 'pcs' }}</span>
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

            <!-- Footer Calculations & Summary (Stripe Style) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="flex flex-col justify-center">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-3xl p-8 border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-50"></div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 italic">Corporate Notes:</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed font-medium">
                            Please complete payment within 14 days of issue. All banking transaction fees are the responsibility of the sender. Thank you for choosing Mesama Global as your trusted partner.
                        </p>
                    </div>
                </div>
                <div>
                    <div class="space-y-4 p-4">
                        <div class="flex justify-between items-center text-sm font-bold text-gray-400">
                            <span class="uppercase tracking-widest text-[10px]">Taxable Amount</span>
                            <span class="text-gray-900 dark:text-white">Rp {{ number_format($salesOrder->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm font-bold text-gray-400 pb-4 border-b border-gray-100 dark:border-gray-800">
                            <span class="uppercase tracking-widest text-[10px]">Value Added Tax (0%)</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-4">
                            <div>
                                <span class="text-[10px] font-black text-gray-900 dark:text-white uppercase tracking-[0.3em]">TOTAL DUE</span>
                                <p class="text-[9px] text-emerald-500 font-bold uppercase mt-1">Authorized for release</p>
                            </div>
                            <span class="text-4xl font-black text-blue-600 tracking-tighter leading-none">Rp {{ number_format($salesOrder->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Verification Area -->
            <div class="mt-24 pt-16 border-t-2 border-gray-50 dark:border-gray-800 grid grid-cols-2 gap-20">
                <div class="text-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-20 italic">AUTHORIZED SIGNATURE</p>
                    <div class="flex flex-col items-center">
                        <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight leading-none mb-2">{{ $salesOrder->creator->name }}</p>
                        <div class="h-1 w-16 bg-blue-600 rounded-full opacity-30"></div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase mt-4 italic tracking-[0.2em]">Head of Finance</p>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-20 italic">CUSTOMER ACCEPTANCE</p>
                    <div class="border-b-2 border-gray-100 dark:border-gray-700 mx-auto w-48 mb-4 border-dashed"></div>
                    <p class="text-[9px] text-gray-400 font-bold uppercase italic tracking-[0.2em]">Signature & Official Stamp</p>
                </div>
            </div>
            
            <!-- Floating Corporate Footer -->
            <div class="mt-20 pt-10 text-center border-t border-gray-50 dark:border-gray-800">
                <p class="text-[9px] text-gray-300 font-black uppercase tracking-[0.8em]">MESAMA GLOBAL INDONESIA | WORLD CLASS LOGISTICS</p>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
