@php
    $oldChildren = old('children') ?: [
        [
            'name' => '',
            'birth_date' => '',
            'school_name' => '',
            'grade_level' => '',
        ],
    ];
    $initialChildrenCount = count($oldChildren);
@endphp

<div class="form-section" x-data="{ children: {{ $initialChildrenCount }} }">
    <div class="form-accent bg-gradient-to-b from-amber-500 to-orange-600"></div>
    <div class="pl-4">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0118 20.944M12 14L5.84 10.578A12.083 12.083 0 006 20.944M12 14v7"/>
                    </svg>
                    Data Anak
                </h3>
                <p class="mt-1 text-xs font-semibold text-slate-500">Minimal satu anak wajib diisi saat membuat client baru.</p>
            </div>
            <button type="button" @click="children++" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#205085] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#1b406b]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Anak
            </button>
        </div>

        <div class="space-y-4">
            @foreach($oldChildren as $index => $child)
                <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4" x-show="{{ $index }} < children">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <p class="text-sm font-black text-slate-800">Anak {{ $index + 1 }}</p>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="form-label">Nama Anak <span class="text-red-500">*</span></label>
                            <input type="text" name="children[{{ $index }}][name]" value="{{ old("children.{$index}.name", $child['name'] ?? '') }}" required class="input-premium @error("children.{$index}.name") border-red-500 @enderror" placeholder="Nama lengkap anak">
                            @error("children.{$index}.name")<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="children[{{ $index }}][birth_date]" value="{{ old("children.{$index}.birth_date", $child['birth_date'] ?? '') }}" class="input-premium @error("children.{$index}.birth_date") border-red-500 @enderror">
                            @error("children.{$index}.birth_date")<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Kelas/Jenjang</label>
                            <select name="children[{{ $index }}][grade_level]" class="input-premium @error("children.{$index}.grade_level") border-red-500 @enderror">
                                <option value="">Pilih Grade</option>
                                @foreach($gradeLevels as $gradeLevel)
                                    <option value="{{ $gradeLevel->name }}" {{ old("children.{$index}.grade_level", $child['grade_level'] ?? '') === $gradeLevel->name ? 'selected' : '' }}>
                                        {{ $gradeLevel->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error("children.{$index}.grade_level")<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="form-label">Sekolah</label>
                            <input type="text" name="children[{{ $index }}][school_name]" value="{{ old("children.{$index}.school_name", $child['school_name'] ?? '') }}" class="input-premium @error("children.{$index}.school_name") border-red-500 @enderror" placeholder="Nama sekolah atau home">
                            @error("children.{$index}.school_name")<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="form-label">Foto Anak</label>
                            <input type="file" name="children[{{ $index }}][photo]" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-bold file:text-slate-700 @error("children.{$index}.photo") border-red-500 @enderror">
                            <p class="mt-1 text-xs text-slate-400">Opsional, maksimal 2 MB.</p>
                            @error("children.{$index}.photo")<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            @endforeach

            <template x-for="index in Math.max(children - {{ $initialChildrenCount }}, 0)" :key="'new-child-' + index">
                <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <p class="text-sm font-black text-slate-800">Anak <span x-text="{{ $initialChildrenCount }} + index"></span></p>
                        <button type="button" @click="children = Math.max(children - 1, 1)" class="text-xs font-bold text-red-600 hover:text-red-700">Hapus</button>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="form-label">Nama Anak <span class="text-red-500">*</span></label>
                            <input type="text" :name="'children[' + ({{ $initialChildrenCount }} + index - 1) + '][name]'" required class="input-premium" placeholder="Nama lengkap anak">
                        </div>
                        <div>
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" :name="'children[' + ({{ $initialChildrenCount }} + index - 1) + '][birth_date]'" class="input-premium">
                        </div>
                        <div>
                            <label class="form-label">Kelas/Jenjang</label>
                            <select :name="'children[' + ({{ $initialChildrenCount }} + index - 1) + '][grade_level]'" class="input-premium">
                                <option value="">Pilih Grade</option>
                                @foreach($gradeLevels as $gradeLevel)
                                    <option value="{{ $gradeLevel->name }}">{{ $gradeLevel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Sekolah</label>
                            <input type="text" :name="'children[' + ({{ $initialChildrenCount }} + index - 1) + '][school_name]'" class="input-premium" placeholder="Nama sekolah atau home">
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Foto Anak</label>
                            <input type="file" :name="'children[' + ({{ $initialChildrenCount }} + index - 1) + '][photo]'" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-bold file:text-slate-700">
                            <p class="mt-1 text-xs text-slate-400">Opsional, maksimal 2 MB.</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
