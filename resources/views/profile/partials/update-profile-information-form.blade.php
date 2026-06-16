<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6" id="profile-form">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" value="Foto Profil" />
            <div class="mt-2 flex items-center gap-4">
                <img
                    id="avatar-preview"
                    src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=205085&color=fff&size=128' }}"
                    alt="Foto profil {{ $user->name }}"
                    class="h-20 w-20 rounded-full object-cover ring-4 ring-slate-100"
                >
                <div class="flex-1">
                    <input id="avatar" name="avatar" type="file" accept="image/*" class="block w-full rounded-md border border-gray-300 text-sm text-gray-700 file:mr-4 file:border-0 file:bg-[#205085] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#173b63]" />
                    <p class="mt-2 text-xs text-gray-500">Opsional. Maksimal 5MB, otomatis dikompres oleh sistem.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
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
        const modal = document.getElementById('avatar-crop-modal');
        const closeButton = document.getElementById('avatar-crop-close');
        const cancelButton = document.getElementById('avatar-crop-cancel');
        const applyButton = document.getElementById('avatar-crop-apply');
        const stage = document.getElementById('avatar-crop-stage');
        const cropImage = document.getElementById('avatar-crop-image');
        const zoomInput = document.getElementById('avatar-zoom');

        if (!input || !preview || !modal || !stage || !cropImage || !zoomInput) {
            return;
        }

        const state = {
            fileName: null,
            image: null,
            imageUrl: null,
            stageSize: 0,
            baseScale: 1,
            zoom: 1,
            offsetX: 0,
            offsetY: 0,
            dragging: false,
            dragStartX: 0,
            dragStartY: 0,
            dragOriginX: 0,
            dragOriginY: 0,
        };

        const resetCropState = (clearInput = false) => {
            if (state.imageUrl) {
                URL.revokeObjectURL(state.imageUrl);
            }

            state.fileName = null;
            state.image = null;
            state.imageUrl = null;
            state.stageSize = 0;
            state.baseScale = 1;
            state.zoom = 1;
            state.offsetX = 0;
            state.offsetY = 0;
            state.dragging = false;
            zoomInput.value = '1';
            cropImage.removeAttribute('src');

            if (clearInput) {
                input.value = '';
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
            const maxOffsetX = Math.max((displayWidth - state.stageSize) / 2, 0);
            const maxOffsetY = Math.max((displayHeight - state.stageSize) / 2, 0);

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
            state.baseScale = Math.max(
                state.stageSize / state.image.naturalWidth,
                state.stageSize / state.image.naturalHeight
            );
            state.zoom = 1;
            state.offsetX = 0;
            state.offsetY = 0;
            zoomInput.value = '1';
            renderCropImage();
        };

        const replaceInputFile = async () => {
            const canvas = document.createElement('canvas');
            canvas.width = 720;
            canvas.height = 720;

            const ctx = canvas.getContext('2d');
            const displayWidth = state.image.naturalWidth * state.baseScale * state.zoom;
            const displayHeight = state.image.naturalHeight * state.baseScale * state.zoom;
            const sourceX = ((displayWidth - state.stageSize) / 2 - state.offsetX) / (state.baseScale * state.zoom);
            const sourceY = ((displayHeight - state.stageSize) / 2 - state.offsetY) / (state.baseScale * state.zoom);
            const sourceSize = state.stageSize / (state.baseScale * state.zoom);

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
        };

        input.addEventListener('change', (event) => {
            const [file] = event.target.files || [];

            if (!file) {
                return;
            }

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
            state.zoom = Number(zoomInput.value);
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
