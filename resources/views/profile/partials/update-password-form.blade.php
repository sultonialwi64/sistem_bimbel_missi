<section>
    <header class="flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-[#205085]/10 text-[#205085]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V9a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="mt-4 text-2xl font-black text-slate-950">
                Keamanan Akun
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">
                Jaga akun Anda tetap aman dengan password yang kuat dan hanya diketahui oleh Anda sendiri.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 sm:max-w-xs">
            <p class="text-[11px] font-black uppercase tracking-wide text-slate-400">Keamanan Login</p>
            <p class="mt-1 text-sm font-bold text-slate-900">Password baru akan langsung dipakai saat login berikutnya.</p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div class="grid gap-5 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-5">
                <p class="text-sm font-black text-slate-900">Tips Password</p>
                <ul class="mt-3 space-y-2 text-sm leading-6 text-slate-600">
                    <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol.</li>
                    <li>Hindari nama pribadi atau tanggal lahir yang mudah ditebak.</li>
                    <li>Ganti password bila akun dipakai di perangkat lain.</li>
                </ul>
            </div>

            <div class="space-y-5 lg:col-span-2">
                <div>
                    <x-input-label for="update_password_current_password" value="Password Saat Ini" class="text-sm font-black text-slate-900" />
                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full rounded-2xl border-slate-300 py-3 text-base shadow-sm focus:border-[#205085] focus:ring-[#205085]" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <x-input-label for="update_password_password" value="Password Baru" class="text-sm font-black text-slate-900" />
                        <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full rounded-2xl border-slate-300 py-3 text-base shadow-sm focus:border-[#205085] focus:ring-[#205085]" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="update_password_password_confirmation" value="Konfirmasi Password Baru" class="text-sm font-black text-slate-900" />
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-2xl border-slate-300 py-3 text-base shadow-sm focus:border-[#205085] focus:ring-[#205085]" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black text-slate-900">Simpan password baru</p>
                <p class="mt-1 text-xs leading-6 text-slate-500">Password baru akan langsung dipakai untuk login berikutnya.</p>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button class="rounded-full bg-[#205085] px-6 py-3 text-sm font-black uppercase tracking-wide hover:bg-[#173b63]">
                    Simpan Password
                </x-primary-button>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm font-bold text-green-700"
                    >Password diperbarui.</p>
                @endif
            </div>
        </div>
    </form>
</section>
