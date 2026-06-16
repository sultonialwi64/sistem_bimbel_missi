<section class="space-y-6">
    <header class="flex flex-col gap-4 border-b border-red-100 pb-6 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/>
                </svg>
            </div>
            <h2 class="mt-4 text-2xl font-black text-red-700">
                Hapus Akun
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">
                Tindakan ini bersifat permanen. Gunakan hanya jika akun memang perlu dihapus sepenuhnya dari sistem.
            </p>
        </div>

        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 sm:max-w-xs">
            <p class="text-[11px] font-black uppercase tracking-wide text-red-500">Perhatian</p>
            <p class="mt-1 text-sm font-bold text-red-800">Data terhubung bisa ikut hilang permanen sesuai relasi sistem.</p>
        </div>
    </header>

    <div class="rounded-3xl border border-red-200 bg-red-50 p-5">
        <p class="text-sm font-bold leading-7 text-red-900">Setelah akun dihapus, seluruh resource yang terhubung ke akun ini dapat ikut terhapus permanen sesuai relasi yang berlaku di sistem.</p>

        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="mt-4 rounded-full bg-red-600 px-6 py-3 text-sm font-black uppercase tracking-wide hover:bg-red-700"
        >Hapus Akun</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-slate-950">
                Yakin ingin menghapus akun ini?
            </h2>

            <p class="mt-2 text-sm leading-7 text-slate-600">
                Semua data yang terhubung ke akun ini akan ikut terhapus permanen. Masukkan password untuk konfirmasi.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-slate-300 py-3 text-base shadow-sm focus:border-red-500 focus:ring-red-500 sm:w-3/4"
                    placeholder="Password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-full px-5 py-3">
                    Batal
                </x-secondary-button>

                <x-danger-button class="ms-3 rounded-full bg-red-600 px-5 py-3 text-sm font-black uppercase tracking-wide hover:bg-red-700">
                    Hapus Permanen
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
