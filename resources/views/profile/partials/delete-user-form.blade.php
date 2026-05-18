<section class="space-y-6">
    <p class="text-sm text-error-600 dark:text-error-400">
        {{ __('Peringatan: Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Harap unduh data atau informasi apa pun yang ingin Anda simpan sebelum menghapus akun.') }}
    </p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-transparent bg-error-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-error-700 focus:outline-none focus:ring-2 focus:ring-error-500 focus:ring-offset-2 transition dark:focus:ring-offset-gray-800"
    >
        {{ __('Hapus Akun Permanen') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="bg-transparent p-6 sm:p-8 dark:bg-gray-900">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-error-500"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Setelah akun dihapus, semua data terkait akan dihapus secara permanen. Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda benar-benar ingin melakukan tindakan ini.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full rounded-lg border border-gray-300 bg-transparent py-3 pl-11 pr-4 text-gray-900 outline-none transition focus:border-error-500 focus:ring-1 focus:ring-error-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-error-500"
                        placeholder="{{ __('Masukkan password Anda...') }}"
                    />
                </div>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03] dark:focus:ring-offset-gray-900">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-transparent bg-error-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-error-700 focus:outline-none focus:ring-2 focus:ring-error-500 focus:ring-offset-2 transition dark:focus:ring-offset-gray-900">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
