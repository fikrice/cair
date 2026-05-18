@extends('layouts.app')

@section('content')
    <!-- Dashboard Hero Section -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Access Control Management</h2>
            <p class="text-sm text-gray-500">Kelola otoritas pengguna, hak akses departemen, dan kredensial sistem.</p>
        </div>
    </div>

    <!-- Main Content Card (Filter + Table) -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Filter & Search Header -->
        <div class="px-5 py-5 sm:px-6 sm:py-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-3" 
                    x-data="{ 
                        search: '{{ request('search') }}',
                        role: '{{ request('role') }}',
                        updateFilters() {
                            const url = new URL(window.location.href);
                            if (this.search) { url.searchParams.set('search', this.search); url.searchParams.set('page', 1); }
                            else { url.searchParams.delete('search'); }
                            
                            if (this.role) { url.searchParams.set('role', this.role); url.searchParams.set('page', 1); }
                            else { url.searchParams.delete('role'); }
                            
                            window.location.href = url.toString();
                        }
                    }"
                    x-init="$watch('search', value => updateFilters())">
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-80">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        </span>
                        <input type="text" x-model.debounce.500ms="search" placeholder="Cari nama atau email user..." 
                            class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>

                    <!-- Role Filter -->
                    <div class="relative">
                        <select x-model="role" @change="updateFilters()" 
                            class="appearance-none rounded-xl border border-gray-200 bg-white py-2.5 pl-5 pr-10 text-sm font-medium text-gray-700 outline-hidden transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/5 dark:border-gray-700 dark:bg-gray-800 dark:text-white cursor-pointer">
                            <option value="">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="finance">Finance</option>
                            <option value="warehouse">Warehouse</option>
                            <option value="purchasing">Purchasing</option>
                        </select>
                        <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                        </span>
                    </div>
                </div>

                <!-- Create Button -->
                <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-bold text-white hover:bg-brand-600 transition shadow-theme-md active:scale-95">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Provision New User
                </a>
            </div>
        </div>

        <!-- Table Area -->
        <div class="max-w-full overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-y border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-12">No</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Registration Date</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">User Profile</th>
                        <th class="px-5 py-3 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Role & Access</th>
                        <th class="px-5 py-3 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($users as $index => $user)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-800 dark:text-white">{{ $user->created_at->format('d M Y') }}</span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 font-bold text-xs uppercase">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                @php
                                    $roleDots = [
                                        'admin' => 'bg-error-500',
                                        'finance' => 'bg-success-500',
                                        'warehouse' => 'bg-brand-500',
                                        'purchasing' => 'bg-amber-500',
                                    ];
                                @endphp
                                <div class="h-2 w-2 rounded-full {{ $roleDots[$user->role] ?? 'bg-gray-400' }}"></div>
                                <span class="text-sm font-semibold text-gray-800 dark:text-white/90 uppercase tracking-tight">{{ $user->role }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('users.edit', $user) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:border-brand-300 hover:text-brand-500 transition dark:border-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:border-brand-500" title="Edit User">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form x-ref="deleteForm{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" @click="$dispatch('confirm', { title: 'Hapus User?', message: 'Apakah Anda yakin ingin menghapus user {{ $user->name }}? Akses sistem akan dicabut sepenuhnya.', confirmText: 'Ya, Hapus', cancelText: 'Batal', type: 'danger', onConfirm: () => $refs.deleteForm{{ $user->id }}.submit() })"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-error-500 hover:bg-error-50 transition dark:border-gray-800 dark:bg-transparent dark:hover:bg-error-500/10" title="Hapus">
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M14.25 4.5V15C14.25 15.4142 13.9142 15.75 13.5 15.75H4.5C4.08579 15.75 3.75 15.4142 3.75 15V4.5M2.25 4.5H15.75M7.5 7.5V12.75M10.5 7.5V12.75M6.75 2.25H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400 uppercase text-xs font-bold tracking-widest italic">No system users identified.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="p-5 border-t border-gray-100 dark:border-gray-800">
            {{ $users->links() }}
        </div>
        @endif
    </div>
@endsection
