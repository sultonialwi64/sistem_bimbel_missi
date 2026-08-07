@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto pb-12">
    <!-- Breadcrumb & Nav -->
    <div class="flex items-center gap-3 text-sm text-slate-500 bg-white/50 backdrop-blur-md px-6 py-3 rounded-2xl border border-slate-200/60 shadow-sm w-fit">
        <a href="{{ route('admin.learning-media.index') }}" class="hover:text-indigo-600 transition-colors flex items-center gap-1.5 font-semibold">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Media Belajar
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-900 font-bold truncate max-w-[200px]">{{ $learningMedia->title }}</span>
        <span class="text-slate-300">/</span>
        <span class="text-slate-900 font-bold">Edit</span>
    </div>

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-900 to-slate-900 p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[50%] -right-[10%] w-[50%] h-[150%] rounded-full bg-indigo-500/20 blur-[100px]"></div>
            <div class="absolute -bottom-[50%] -left-[10%] w-[50%] h-[150%] rounded-full bg-purple-500/20 blur-[100px]"></div>
        </div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="p-4 bg-white/10 rounded-2xl backdrop-blur-md border border-white/20">
                <svg class="h-8 w-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-1">Edit Materi Belajar</h1>
                <p class="text-indigo-200 text-lg">Perbarui informasi materi, ubah file, atau atur hak akses.</p>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <form action="{{ route('admin.learning-media.update', $learningMedia) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[2rem] shadow-xl border border-slate-200/60 overflow-hidden" x-data="{ mediaType: '{{ old('type', $learningMedia->type) }}' }">
        @csrf
        @method('PUT')
        
        <div class="p-8 sm:p-10 space-y-10">
            <!-- Basic Info Section -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Informasi Dasar</h3>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Materi / Game <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors py-3 px-4 bg-slate-50 hover:bg-white focus:bg-white" value="{{ old('title', $learningMedia->title) }}" required>
                        @error('title') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Lengkap</label>
                        <textarea name="description" id="description" rows="4" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors py-3 px-4 bg-slate-50 hover:bg-white focus:bg-white" placeholder="Jelaskan secara singkat tentang materi ini...">{{ old('description', $learningMedia->description) }}</textarea>
                        @error('description') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategori Materi <span class="text-rose-500">*</span></label>
                        <select name="category" id="category" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors py-3 px-4 bg-slate-50 hover:bg-white focus:bg-white" required>
                            <option value="Umum" {{ old('category', $learningMedia->category) == 'Umum' ? 'selected' : '' }}>Umum</option>
                            <option value="Calistung" {{ old('category', $learningMedia->category) == 'Calistung' ? 'selected' : '' }}>Calistung</option>
                            <option value="Bahasa Inggris" {{ old('category', $learningMedia->category) == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="Matematika" {{ old('category', $learningMedia->category) == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                            <option value="Sains" {{ old('category', $learningMedia->category) == 'Sains' ? 'selected' : '' }}>Sains</option>
                        </select>
                        @error('category') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Content Type Section -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Tipe & File Materi</h3>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-4">Pilih Tipe Media <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="pdf" x-model="mediaType" class="peer sr-only">
                            <div class="p-5 border-2 rounded-2xl transition-all duration-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 hover:border-slate-300 border-slate-200 bg-white">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-rose-50 text-rose-600 rounded-xl peer-checked:bg-rose-100">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">PDF File</div>
                                        <div class="text-xs text-slate-500 font-medium">Upload dokumen PDF</div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute inset-0 border-2 border-indigo-600 rounded-2xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="video" x-model="mediaType" class="peer sr-only">
                            <div class="p-5 border-2 rounded-2xl transition-all duration-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 hover:border-slate-300 border-slate-200 bg-white">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl peer-checked:bg-blue-100">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">Video Link</div>
                                        <div class="text-xs text-slate-500 font-medium">URL YouTube/External</div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute inset-0 border-2 border-indigo-600 rounded-2xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="web_game" x-model="mediaType" class="peer sr-only">
                            <div class="p-5 border-2 rounded-2xl transition-all duration-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 hover:border-slate-300 border-slate-200 bg-white">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-purple-50 text-purple-600 rounded-xl peer-checked:bg-purple-100">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">Web Game</div>
                                        <div class="text-xs text-slate-500 font-medium">Embed URL HTML5</div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute inset-0 border-2 border-indigo-600 rounded-2xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></div>
                        </label>
                    </div>
                    @error('type') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- PDF File Upload (Conditional) -->
                <div x-show="mediaType === 'pdf'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: {{ old('type', $learningMedia->type) === 'pdf' ? 'block' : 'none' }};" x-data="{ fileName: '' }">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Upload File PDF Baru (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-2xl bg-slate-50 hover:bg-slate-100 transition-colors relative group">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file_pdf" class="relative cursor-pointer bg-transparent rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span x-text="fileName === '' ? 'Pilih file' : 'Ganti file'">Pilih file</span>
                                    <input id="file_pdf" name="file" type="file" class="sr-only" accept=".pdf" @change="fileName = $event.target.files[0].name">
                                </label>
                                <p class="pl-1" x-show="fileName === ''">atau drag & drop</p>
                            </div>
                            <p class="text-xs font-bold text-indigo-600 mt-2" x-show="fileName !== ''" x-text="fileName"></p>
                            <p class="text-xs text-slate-500" x-show="fileName === ''">PDF maksimal 10MB. Biarkan kosong jika tidak ingin mengubah file.</p>
                            @if($learningMedia->file_path && $learningMedia->type === 'pdf')
                                <div class="mt-3 flex items-center justify-center gap-2 bg-emerald-50 text-emerald-700 text-xs font-semibold px-4 py-2 rounded-full border border-emerald-200 w-fit mx-auto" x-show="fileName === ''">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    File saat ini: {{ basename($learningMedia->file_path) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @error('file') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- External URL (Conditional) -->
                <div x-show="mediaType !== 'pdf'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: {{ old('type', $learningMedia->type) !== 'pdf' ? 'block' : 'none' }};">
                    <label for="url" class="block text-sm font-semibold text-slate-700 mb-2" x-text="mediaType === 'video' ? 'Link YouTube/Video URL' : 'Link Web Game/Iframe URL'">URL Eksternal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <input type="url" name="url" id="url" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors py-3 pl-11 pr-4 bg-slate-50 hover:bg-white focus:bg-white" value="{{ old('url', $learningMedia->url) }}" placeholder="https://...">
                    </div>
                    @error('url') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- Thumbnail Upload -->
                <div x-data="{ thumbName: '' }">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Thumbnail Cover Baru (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-2xl bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="space-y-1 text-center">
                            @if($learningMedia->thumbnail_path)
                                <img src="{{ Storage::url($learningMedia->thumbnail_path) }}" class="mx-auto h-20 w-20 object-cover rounded-xl shadow-md border border-slate-200 mb-3" x-show="thumbName === ''">
                                <svg class="mx-auto h-12 w-12 text-indigo-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" x-show="thumbName !== ''" style="display: none;">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @else
                                <svg class="mx-auto h-12 w-12" :class="thumbName === '' ? 'text-slate-400' : 'text-indigo-500'" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="thumbnail" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                    <span x-text="thumbName === '' ? 'Upload gambar' : 'Ganti gambar'">Upload gambar</span>
                                    <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/*" @change="thumbName = $event.target.files[0].name">
                                </label>
                            </div>
                            <p class="text-xs font-bold text-indigo-600 mt-2" x-show="thumbName !== ''" x-text="thumbName"></p>
                            <p class="text-xs text-slate-500" x-show="thumbName === ''">PNG, JPG, GIF hingga 2MB (Disarankan rasio 4:3). Biarkan kosong jika tidak diubah.</p>
                        </div>
                    </div>
                    @error('thumbnail') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Settings Section -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Pengaturan Akses</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <label class="relative flex cursor-pointer rounded-2xl border-2 border-slate-200 bg-white p-5 focus:outline-none hover:border-slate-300 transition-colors">
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p class="font-bold text-slate-900">Status Aktif</p>
                                    <div class="text-slate-500 font-medium">Tampilkan ke client & tutor</div>
                                </div>
                            </div>
                            <div class="ml-4 flex h-6 items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $learningMedia->is_active) ? 'checked' : '' }} class="h-6 w-6 rounded text-indigo-600 focus:ring-indigo-600 transition-colors">
                            </div>
                        </div>
                    </label>

                    <label class="relative flex cursor-pointer rounded-2xl border-2 border-slate-200 bg-white p-5 focus:outline-none hover:border-slate-300 transition-colors">
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p class="font-bold text-slate-900 flex items-center gap-1.5">
                                        Konten Premium
                                        <svg class="h-4 w-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    </p>
                                    <div class="text-slate-500 font-medium">Tandai sebagai materi khusus</div>
                                </div>
                            </div>
                            <div class="ml-4 flex h-6 items-center">
                                <input type="hidden" name="is_premium" value="0">
                                <input type="checkbox" name="is_premium" value="1" {{ old('is_premium', $learningMedia->is_premium) ? 'checked' : '' }} class="h-6 w-6 rounded text-amber-500 focus:ring-amber-500 transition-colors">
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.learning-media.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all shadow-md shadow-indigo-200 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
