@props(['name' => 'client_id', 'value' => null])

@php
    $initialName = '';
    if ($value) {
        $client = \App\Models\Client::with('user')->find($value);
        if ($client) {
            $initialName = $client->user->name;
        }
    }
@endphp

<div x-data="clientSelector('{{ $value }}', '{{ $initialName }}')" class="relative">
    <input type="hidden" name="{{ $name }}" x-model="selectedId" required>
    
    <div class="relative">
        <div class="flex items-center">
            <input type="text" x-model="selectedName" readonly placeholder="Pilih Parent/Client..." @click="openModal()"
                class="block w-full rounded-md border-gray-300 bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500 cursor-pointer hover:bg-gray-100 transition-colors">
        </div>
        <p x-show="!selectedId" class="text-xs text-red-500 mt-1">Harap pilih parent terlebih dahulu.</p>
    </div>

    <!-- Modal -->
    <div x-show="showModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="showModal" @click.away="closeModal()" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl border border-gray-100 flex flex-col max-h-[80vh]">
                    
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-indigo-50/50">
                        <h3 class="text-lg font-bold text-gray-900" id="modal-title">Cari Parent / Client</h3>
                        <button type="button" @click="closeModal()" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Tutup</span>
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <!-- Search Input -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-white">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                            </div>
                            <input type="text" x-model="searchQuery" @input.debounce.500ms="fetchClients()" placeholder="Ketik nama atau email parent..."
                                class="block w-full pl-10 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-all shadow-sm">
                        </div>
                    </div>

                    <!-- Results Table -->
                    <div class="flex-1 overflow-y-auto bg-gray-50 p-6">
                        <!-- Loading State -->
                        <div x-show="isLoading" class="flex justify-center py-8">
                            <i class="fa-solid fa-circle-notch fa-spin text-3xl text-indigo-500"></i>
                        </div>

                        <!-- Error State -->
                        <div x-show="hasError" class="text-center py-8 text-red-500">
                            <i class="fa-solid fa-triangle-exclamation text-3xl mb-2"></i>
                            <p>Gagal memuat data. Silakan coba lagi.</p>
                        </div>

                        <!-- Empty State -->
                        <div x-show="!isLoading && !hasError && clients.length === 0" class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300"></i>
                            <p>Tidak ada data client ditemukan.</p>
                        </div>

                        <!-- Results Container -->
                        <div x-show="!isLoading && !hasError && clients.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <!-- Desktop Table View -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No Telpon</th>
                                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="client in clients" :key="client.id">
                                            <tr class="hover:bg-indigo-50 transition-colors">
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="font-semibold text-gray-900" x-text="client.name"></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900" x-text="client.email"></div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="text-sm text-gray-500 line-clamp-2" x-text="client.address"></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900" x-text="client.phone || '-'"></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" @click="selectClient(client)" class="px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg font-semibold transition-colors">
                                                        Pilih
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View -->
                            <div class="md:hidden divide-y divide-gray-200">
                                <template x-for="client in clients" :key="client.id">
                                    <div class="p-4 hover:bg-indigo-50 transition-colors">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <div class="font-bold text-gray-900 text-base" x-text="client.name"></div>
                                                <div class="text-sm text-gray-600 mt-0.5" x-text="client.email"></div>
                                            </div>
                                            <button type="button" @click="selectClient(client)" class="px-4 py-2 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg font-bold transition-colors text-sm shrink-0 ml-4">
                                                Pilih
                                            </button>
                                        </div>
                                        <div class="space-y-2 text-sm text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            <div class="flex flex-col">
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No Telpon</span>
                                                <span class="text-gray-900 font-medium" x-text="client.phone || '-'"></span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Alamat</span>
                                                <span class="text-gray-900 font-medium line-clamp-2" x-text="client.address || '-'"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('clientSelector', (initialId, initialName) => ({
            showModal: false,
            searchQuery: '',
            isLoading: false,
            hasError: false,
            clients: [],
            selectedId: initialId,
            selectedName: initialName,

            openModal() {
                this.showModal = true;
                if (this.clients.length === 0) {
                    this.fetchClients();
                }
            },

            closeModal() {
                this.showModal = false;
            },

            fetchClients() {
                this.isLoading = true;
                this.hasError = false;

                const url = new URL('{{ route('search.clients') }}');
                if (this.searchQuery) {
                    url.searchParams.append('q', this.searchQuery);
                }

                fetch(url)
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(data => {
                        this.clients = data;
                        this.isLoading = false;
                    })
                    .catch(err => {
                        console.error('Error fetching clients:', err);
                        this.hasError = true;
                        this.isLoading = false;
                    });
            },

            selectClient(client) {
                this.selectedId = client.id;
                this.selectedName = client.name;
                this.closeModal();
            }
        }));
    });
</script>
