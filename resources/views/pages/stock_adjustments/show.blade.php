@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Detail Penyesuaian</h2>
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li><a class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-500 transition" href="{{ route('stock-adjustments.index') }}">Penyesuaian Stok /</a></li>
                <li class="font-medium text-brand-500">{{ $stockAdjustment->adjustment_number }}</li>
            </ol>
        </nav>
    </div>

    <div class="mx-auto max-w-4xl">
        <div class="rounded-3xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <!-- Header Status -->
            <div class="flex flex-col sm:flex-row items-center justify-between p-8 border-b border-gray-100 dark:border-gray-800 gap-6 bg-gray-50/50 dark:bg-gray-900/20">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $stockAdjustment->type === 'addition' ? 'bg-success-50 text-success-600 dark:bg-success-500/10 dark:text-success-400' : 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400' }}">
                        <i data-lucide="{{ $stockAdjustment->type === 'addition' ? 'plus-circle' : 'minus-circle' }}" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter leading-none">{{ $stockAdjustment->adjustment_number }}</h3>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-2 flex items-center gap-2">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $stockAdjustment->adjustment_date->format('d F Y, H:i') }}
                        </p>
                    </div>
                </div>
                <div>
                    @if($stockAdjustment->type === 'addition')
                        <span class="inline-flex rounded-full bg-success-500 px-5 py-2 text-xs font-black text-white uppercase tracking-widest shadow-lg shadow-success-100">Penambahan Stok</span>
                    @else
                        <span class="inline-flex rounded-full bg-error-500 px-5 py-2 text-xs font-black text-white uppercase tracking-widest shadow-lg shadow-error-100">Pengurangan Stok</span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 sm:p-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Product Info -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Informasi Produk:</p>
                        <div class="flex items-center gap-5 bg-gray-50 dark:bg-gray-800/50 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700">
                            @if($stockAdjustment->product->image)
                                <img src="{{ asset('storage/' . $stockAdjustment->product->image) }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
                            @else
                                <div class="w-16 h-16 bg-white dark:bg-gray-900 rounded-2xl flex items-center justify-center text-gray-300">
                                    <i data-lucide="package" class="w-8 h-8"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-lg font-black text-gray-900 dark:text-white tracking-tight leading-none mb-1 uppercase">{{ $stockAdjustment->product->name }}</h4>
                                <p class="text-xs font-bold text-brand-500 font-mono tracking-widest uppercase italic">{{ $stockAdjustment->product->sku }}</p>
                                <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-widest">Kategori: {{ $stockAdjustment->product->category->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Adjustment Info -->
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Detail Mutasi:</p>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-800">
                                <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Jumlah Qty</span>
                                <span class="text-xl font-black text-gray-900 dark:text-white">{{ $stockAdjustment->type === 'subtraction' ? '-' : '+' }}{{ $stockAdjustment->quantity }} <small class="text-xs text-gray-400 uppercase font-bold">{{ $stockAdjustment->product->unit }}</small></span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-800">
                                <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Alasan Utama</span>
                                <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight italic bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                                    {{ str_replace('_', ' ', $stockAdjustment->reason) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Diproses Oleh</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-brand-500 flex items-center justify-center text-[10px] text-white font-bold">
                                        {{ substr($stockAdjustment->creator->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-black text-gray-900 dark:text-white">{{ $stockAdjustment->creator->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Area -->
                <div class="mt-12">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Catatan Tambahan:</p>
                    <div class="bg-gray-50 dark:bg-gray-800/50 p-8 rounded-[2rem] border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed font-medium italic">
                            {{ $stockAdjustment->notes ?: 'Tidak ada catatan tambahan untuk penyesuaian ini.' }}
                        </p>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="mt-12 flex justify-center border-t border-gray-100 pt-10 dark:border-gray-800">
                    <a href="{{ route('stock-adjustments.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white border border-gray-200 px-10 py-3 text-sm font-bold text-gray-600 hover:bg-gray-50 transition dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endpush
