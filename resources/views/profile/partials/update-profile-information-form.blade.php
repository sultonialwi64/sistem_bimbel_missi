<section>
    <header class="border-b border-slate-200 pb-6">
        <div>
            <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-[#205085]/10 text-[#205085]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h2 class="mt-4 text-2xl font-black text-slate-950">
                Informasi Profil
            </h2>
            <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600">
                Perbarui identitas akun dan foto profil Anda. Perubahan di sini dipakai sebagai identitas utama akun pada sistem.
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-8" id="profile-form">
        @csrf
        @method('patch')

        <div class="grid gap-6 lg:grid-cols-[300px_minmax(0,1fr)]">
            <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-black text-slate-950">Foto Profil</p>
                        <p class="mt-1 text-xs leading-6 text-slate-500">Preview yang dipakai untuk sidebar dan kartu tutor.</p>
                    </div>
                    <span class="rounded-full bg-[#205085]/10 px-3 py-1 text-[11px] font-black uppercase tracking-wide text-[#205085]">Avatar</span>
                </div>

                <div class="mt-6 flex flex-col items-center gap-5">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-full bg-[#205085]/10 blur-xl"></div>
                        <img
                            id="avatar-preview"
                            src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=205085&color=fff&size=128' }}"
                            alt="Foto profil {{ $user->name }}"
                            class="relative h-32 w-32 rounded-full object-cover ring-4 ring-white shadow-xl"
                        >
                    </div>

                    <div class="w-full rounded-3xl border border-dashed border-slate-300 bg-white p-4">
                        <input id="avatar" name="avatar" type="file" accept="image/*" class="sr-only" />

                        <div class="flex flex-col gap-3">
                            <label for="avatar" class="inline-flex min-h-12 cursor-pointer items-center justify-center rounded-full bg-[#205085] px-5 py-3 text-sm font-black text-white transition hover:bg-[#173b63]">
                                Pilih Foto Baru
                            </label>

                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <p class="text-[11px] font-black uppercase tracking-wide text-slate-400">File terpilih</p>
                                <p id="avatar-file-name" class="mt-1 truncate text-sm font-semibold text-slate-700">Belum ada file dipilih</p>
                            </div>
                        </div>

                        <p class="mt-4 text-xs leading-6 text-slate-500">Maksimal 5MB. Setelah memilih file, sistem akan membuka crop bulat agar posisi foto bisa dirapikan dulu sebelum disimpan.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <x-input-label for="name" value="Nama Lengkap" class="text-sm font-black text-slate-900" />
                    <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-2xl border-slate-300 py-3 text-base shadow-sm focus:border-[#205085] focus:ring-[#205085]" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <p class="mt-2 text-xs leading-6 text-slate-500">Gunakan nama yang ingin tampil konsisten pada akun dan halaman kerja Anda.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" class="text-sm font-black text-slate-900" />
                    <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-2xl border-slate-300 py-3 text-base shadow-sm focus:border-[#205085] focus:ring-[#205085]" :value="old('email', $user->email)" required autocomplete="username" />
                    <p class="mt-2 text-xs leading-6 text-slate-500">Email ini dipakai untuk login dan notifikasi akun bila diperlukan.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="rounded-3xl border border-amber-200 bg-amber-50/80 p-5">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-black text-amber-900">Email ini belum terverifikasi</p>
                                <p class="mt-1 text-sm leading-6 text-amber-800">Silakan kirim ulang email verifikasi bila Anda membutuhkannya.</p>
                            </div>

                            <button form="send-verification" class="inline-flex min-h-11 items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-black text-amber-800 shadow-sm transition hover:bg-amber-100">
                                Kirim ulang email verifikasi
                            </button>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-3 text-sm font-bold text-green-700">
                                Link verifikasi baru sudah dikirim ke email Anda.
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col gap-3 rounded-[26px] border border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-black text-slate-900">Simpan perubahan profil</p>
                <p class="mt-1 text-xs leading-6 text-slate-500">Perubahan nama, email, dan foto akan langsung dipakai setelah tersimpan.</p>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button class="rounded-full bg-[#205085] px-6 py-3 text-sm font-black uppercase tracking-wide hover:bg-[#173b63]">
                    Simpan Profil
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm font-bold text-green-700"
                    >Profil tersimpan.</p>
                @endif
            </div>
        </div>
    </form>

    <div id="avatar-crop-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm">
        <div class="w-full max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                <div>
                    <h3 class="text-xl font-black text-slate-950">Atur Foto Profil</h3>
                    <p class="mt-1 text-sm text-slate-500">Geser dan perbesar foto agar bagian wajah pas di lingkaran.</p>
                </div>
                <button type="button" id="avatar-crop-close" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="grid gap-6 px-6 py-6 lg:grid-cols-[minmax(0,1.2fr)_minmax(320px,.8fr)]">
                <div>
                    <div id="avatar-crop-stage" class="relative mx-auto flex aspect-square w-full max-w-[420px] cursor-grab items-center justify-center overflow-hidden rounded-[2rem] bg-slate-100 shadow-inner">
                        <img id="avatar-crop-image" alt="Preview crop avatar" class="pointer-events-none absolute max-w-none select-none">
                        <div class="pointer-events-none absolute inset-0 bg-slate-950/38"></div>
                        <div class="pointer-events-none absolute left-1/2 top-1/2 h-[78%] w-[78%] -translate-x-1/2 -translate-y-1/2 rounded-full border-4 border-white shadow-[0_0_0_9999px_rgba(15,23,42,0.02)]"></div>
                    </div>
                    <p class="mt-4 text-center text-xs font-semibold text-slate-500">Preview mengikuti bentuk avatar bundar yang dipakai di landing page.</p>
                </div>

                <div class="space-y-5">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <label for="avatar-zoom" class="text-sm font-black text-slate-900">Perbesar / Perkecil</label>
                        <input id="avatar-zoom" type="range" min="1" max="3" step="0.01" value="1" class="mt-3 h-2 w-full cursor-pointer appearance-none rounded-full bg-slate-200 accent-[#205085]">
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-sm font-black text-slate-900">Tips</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Usahakan wajah ada di tengah lingkaran dan tidak terlalu mepet tepi, supaya tampil rapi di kartu tutor.</p>
                    </div>

                    <div class="flex flex-col gap-3 pt-2 sm:flex-row">
                        <button type="button" id="avatar-crop-cancel" class="inline-flex min-h-12 flex-1 items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-700 transition hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="button" id="avatar-crop-apply" class="inline-flex min-h-12 flex-1 items-center justify-center rounded-full bg-[#205085] px-5 py-3 text-sm font-black text-white transition hover:bg-[#173b63]">
                            Pakai Foto Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('avatar');
        const preview = document.getElementById('avatar-preview');
        const fileName = document.getElementById('avatar-file-name');
        const modal = document.getElementById('avatar-crop-modal');
        const closeButton = document.getElementById('avatar-crop-close');
        const cancelButton = document.getElementById('avatar-crop-cancel');
        const applyButton = document.getElementById('avatar-crop-apply');
        const stage = document.getElementById('avatar-crop-stage');
        const cropImage = document.getElementById('avatar-crop-image');
        const zoomInput = document.getElementById('avatar-zoom');

        if (!input || !preview || !fileName || !modal || !stage || !cropImage || !zoomInput) {
            return;
        }

        const defaultFileName = 'Belum ada file dipilih';

        const state = {
            fileName: null,
            image: null,
            imageUrl: null,
            stageSize: 0,
            cropFrameRatio: 0.78,
            cropFrameSize: 0,
            baseScale: 1,
            minZoom: 1,
            zoom: 1,
            offsetX: 0,
            offsetY: 0,
            dragging: false,
            dragStartX: 0,
            dragStartY: 0,
            dragOriginX: 0,
            dragOriginY: 0,
        };

        const setFileName = (value) => {
            fileName.textContent = value || defaultFileName;
        };

        const resetCropState = (clearInput = false) => {
            if (state.imageUrl) {
                URL.revokeObjectURL(state.imageUrl);
            }

            state.fileName = null;
            state.image = null;
            state.imageUrl = null;
            state.stageSize = 0;
            state.cropFrameSize = 0;
            state.baseScale = 1;
            state.minZoom = 1;
            state.zoom = 1;
            state.offsetX = 0;
            state.offsetY = 0;
            state.dragging = false;
            zoomInput.value = '1';
            cropImage.removeAttribute('src');

            if (clearInput) {
                input.value = '';
                setFileName(defaultFileName);
            }
        };

        const openModal = () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        };

        const closeModal = (clearInput = false) => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
            resetCropState(clearInput);
        };

        const clampOffsets = () => {
            const displayWidth = state.image.naturalWidth * state.baseScale * state.zoom;
            const displayHeight = state.image.naturalHeight * state.baseScale * state.zoom;
            const maxOffsetX = Math.max((displayWidth - state.cropFrameSize) / 2, 0);
            const maxOffsetY = Math.max((displayHeight - state.cropFrameSize) / 2, 0);

            state.offsetX = Math.min(Math.max(state.offsetX, -maxOffsetX), maxOffsetX);
            state.offsetY = Math.min(Math.max(state.offsetY, -maxOffsetY), maxOffsetY);
        };

        const renderCropImage = () => {
            if (!state.image) {
                return;
            }

            clampOffsets();

            const displayWidth = state.image.naturalWidth * state.baseScale * state.zoom;
            const displayHeight = state.image.naturalHeight * state.baseScale * state.zoom;

            cropImage.style.width = `${displayWidth}px`;
            cropImage.style.height = `${displayHeight}px`;
            cropImage.style.left = `calc(50% + ${state.offsetX}px)`;
            cropImage.style.top = `calc(50% + ${state.offsetY}px)`;
            cropImage.style.transform = 'translate(-50%, -50%)';
        };

        const initializeCrop = () => {
            state.stageSize = stage.clientWidth;
            state.cropFrameSize = state.stageSize * state.cropFrameRatio;
            state.baseScale = Math.max(
                state.cropFrameSize / state.image.naturalWidth,
                state.cropFrameSize / state.image.naturalHeight
            );
            state.minZoom = 1;
            zoomInput.min = String(state.minZoom);
            zoomInput.value = String(state.minZoom);
            state.zoom = state.minZoom;
            state.offsetX = 0;
            state.offsetY = 0;
            renderCropImage();
        };

        const replaceInputFile = async () => {
            const canvas = document.createElement('canvas');
            canvas.width = 720;
            canvas.height = 720;

            const ctx = canvas.getContext('2d');
            const displayWidth = state.image.naturalWidth * state.baseScale * state.zoom;
            const displayHeight = state.image.naturalHeight * state.baseScale * state.zoom;
            const sourceX = ((displayWidth - state.cropFrameSize) / 2 - state.offsetX) / (state.baseScale * state.zoom);
            const sourceY = ((displayHeight - state.cropFrameSize) / 2 - state.offsetY) / (state.baseScale * state.zoom);
            const sourceSize = state.cropFrameSize / (state.baseScale * state.zoom);

            ctx.drawImage(
                state.image,
                sourceX,
                sourceY,
                sourceSize,
                sourceSize,
                0,
                0,
                720,
                720
            );

            const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', 0.9));

            if (!blob) {
                return;
            }

            const croppedFile = new File(
                [blob],
                `${(state.fileName || 'avatar').replace(/\.[^/.]+$/, '')}-cropped.jpg`,
                { type: 'image/jpeg' }
            );

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;

            const previewUrl = URL.createObjectURL(blob);
            preview.src = previewUrl;
            setFileName(croppedFile.name);
        };

        input.addEventListener('change', (event) => {
            const [file] = event.target.files || [];

            if (!file) {
                setFileName(defaultFileName);
                return;
            }

            setFileName(file.name);
            state.fileName = file.name;
            state.imageUrl = URL.createObjectURL(file);
            state.image = new Image();
            state.image.onload = () => {
                cropImage.src = state.imageUrl;
                openModal();
                initializeCrop();
            };
            state.image.src = state.imageUrl;
        });

        zoomInput.addEventListener('input', () => {
            state.zoom = Math.max(Number(zoomInput.value), state.minZoom);
            renderCropImage();
        });

        const startDrag = (clientX, clientY) => {
            state.dragging = true;
            state.dragStartX = clientX;
            state.dragStartY = clientY;
            state.dragOriginX = state.offsetX;
            state.dragOriginY = state.offsetY;
            cropImage.style.cursor = 'grabbing';
        };

        const moveDrag = (clientX, clientY) => {
            if (!state.dragging) {
                return;
            }

            state.offsetX = state.dragOriginX + (clientX - state.dragStartX);
            state.offsetY = state.dragOriginY + (clientY - state.dragStartY);
            renderCropImage();
        };

        const endDrag = () => {
            state.dragging = false;
            cropImage.style.cursor = 'grab';
        };

        stage.addEventListener('mousedown', (event) => {
            event.preventDefault();
            startDrag(event.clientX, event.clientY);
        });

        window.addEventListener('mousemove', (event) => moveDrag(event.clientX, event.clientY));
        window.addEventListener('mouseup', endDrag);

        stage.addEventListener('touchstart', (event) => {
            const touch = event.touches[0];
            if (!touch) {
                return;
            }
            startDrag(touch.clientX, touch.clientY);
        }, { passive: true });

        window.addEventListener('touchmove', (event) => {
            const touch = event.touches[0];
            if (!touch) {
                return;
            }
            moveDrag(touch.clientX, touch.clientY);
        }, { passive: true });

        window.addEventListener('touchend', endDrag);

        applyButton.addEventListener('click', async () => {
            await replaceInputFile();
            closeModal(false);
        });

        cancelButton?.addEventListener('click', () => closeModal(true));
        closeButton?.addEventListener('click', () => closeModal(true));

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal(true);
            }
        });

        window.addEventListener('resize', () => {
            if (!modal.classList.contains('hidden') && state.image) {
                initializeCrop();
            }
        });
    });
</script>
@endpush
