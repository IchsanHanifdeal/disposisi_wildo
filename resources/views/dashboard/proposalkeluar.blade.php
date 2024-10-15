<x-dashboard.main title="Proposal Keluar">
    <div class="grid gap-5 md:gap-6">
        <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
            <div class="bg-primary p-3 mr-4 text-white rounded-full flex items-center justify-center">
                <x-lucide-mail class="w-6 h-6" />
            </div>
            <div class="flex-grow">
                <p class="text-sm font-medium capitalize text-base-content">
                    Jumlah proposal Keluar
                </p>
            </div>
            <span class="ml-auto text-lg font-semibold text-base-content">{{ $jumlah_proposal_keluar ?? '0' }}</span>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-5 md:gap-6">
        @foreach (['proposal_terbaru', 'waktu_terdaftar'] as $type)
            <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
                <div
                    class="
                        p-3 mr-4 text-white rounded-full flex items-center justify-center
                        {{ $type == 'proposal_terbaru' ? 'bg-warning' : '' }}
                        {{ $type == 'waktu_terdaftar' ? 'bg-accent' : '' }}
                    ">
                    @if ($type == 'proposal_terbaru')
                        <x-lucide-file-text class="w-6 h-6" />
                    @else
                        <x-lucide-clock class="w-6 h-6" />
                    @endif
                </div>
                <div>
                    <p class="text-sm font-medium capitalize text-base-content">
                        {{ str_replace('_', ' ', $type) }}
                    </p>
                    <p id="{{ $type }}" class="text-lg font-semibold text-base-content">
                        {{ $type == 'proposal_terbaru' ? $proposal_terbaru ?? '-' : '' }}
                        {{ $type == 'waktu_terdaftar' ? $waktu_terdaftar ?? '-' : '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex flex-col lg:flex-row gap-5">
        @foreach (['tambah_proposal'] as $item)
            <div onclick="{{ $item . '_modal' }}.showModal()"
                class="flex items-center justify-between p-5 sm:p-7 hover:shadow-lg hover:bg-gray-700 active:scale-95 transition-all duration-200 ease-in-out border border-gray-600 bg-gray-800 cursor-pointer rounded-xl w-full">
                <div>
                    <h1
                        class="flex items-start gap-3 font-semibold font-sans text-base sm:text-lg capitalize text-gray-200">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <span class="block mt-1 text-sm text-gray-400 leading-relaxed">
                        Tambahkan proposal baru dengan mudah dan kelola data rekap secara efisien.
                    </span>
                </div>
                <x-lucide-plus
                    class="{{ $item == 'tambah_proposal' ? '' : 'hidden' }} size-5 sm:size-7 text-gray-400" />
            </div>
        @endforeach
    </div>
    <div class="flex gap-5">
        @foreach (['Daftar_proposal'] as $item)
            <div class="flex flex-col border border-gray-700 rounded-xl w-full bg-base-200 shadow-lg">
                <div class="p-5 sm:p-7 bg-base-300 rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold text-lg capitalize text-gray-200">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm text-gray-400">
                        Temukan semua proposal yang telah terdaftar dan kelola data dengan mudah di sini.
                    </p>
                </div>
                <div class="flex flex-col bg-base-900 rounded-b-xl gap-3 divide-y divide-gray-600 pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table w-full text-gray-300">
                            <thead>
                                <tr class="bg-base-300">
                                    @foreach (['No', 'No Urut', 'Tanggal', 'File', 'perihal', 'Aksi'] as $header)
                                        <th class="uppercase font-bold text-gray-400">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($proposal_keluar as $i => $item)
                                    <tr class="hover:bg-base-200 transition duration-300">
                                        <th class="font-semibold text-gray-300">{{ $i + 1 }}</th>
                                        <td class="font-semibold uppercase">{{ $item->no_urut }}</td>
                                        <td class="font-semibold uppercase">{{ $item->tanggal_keluar }}</td>
                                        <td class="flex items-center">
                                            <x-lucide-scan-eye class="size-5 hover:stroke-green-500 cursor-pointer"
                                                aria-label="Preview Proposal"
                                                onclick="document.getElementById('preview_modal_{{ $item->id }}').showModal();" />
                                        
                                            <dialog id="preview_modal_{{ $item->id }}" class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-neutral text-white">
                                                    <h3 class="text-lg font-bold" id="modal-title">{{ $item->no_urut }}</h3>
                                                    <div class="flex flex-col w-full mt-3 rounded-lg overflow-hidden h-96">
                                                        @if ($item->file)
                                                            <embed src="{{ asset('storage/proposal_keluar/' . $item->file) }}" type="application/pdf" class="w-full h-full" />
                                                        @else
                                                            <p class="text-red-500">File tidak ditemukan.</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-action">
                                                        <button type="button" onclick="document.getElementById('preview_modal_{{ $item->id }}').close()" class="btn">Tutup</button>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </td>
                                        
                                        <td class="font-semibold uppercase">{{ $item->perihal }}</td>

                                        <td class="flex space-x-2">
                                            <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                                aria-label="Edit Proposal"
                                                onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                            <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                                aria-label="Delete Proposal"
                                                onclick="document.getElementById('delete_modal_{{ $item->id }}').showModal();" />

                                            <!-- Delete Modal -->
                                            <dialog id="delete_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <form action="{{ route('delete.proposal_keluar', $item->id) }}"
                                                    method="POST" class="modal-box bg-base-100 text-gray-900">
                                                    @csrf
                                                    @method('DELETE')
                                                    <h3 class="modal-title capitalize text-white">Konfirmasi Penghapusan
                                                    </h3>
                                                    <div class="modal-body text-white">
                                                        <p>Apakah Anda yakin ingin menghapus proposal ini? Tindakan ini
                                                            tidak dapat dibatalkan.</p>
                                                        <div class="modal-action">
                                                            <button type="button"
                                                                onclick="document.getElementById('delete_modal_{{ $item->id }}').close()"
                                                                class="btn btn-secondary capitalize">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-error capitalize">Hapus</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </dialog>

                                            <!-- Edit Modal -->
                                            <dialog id="update_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <form action="{{ route('update.proposal_keluar', $item->id) }}"
                                                    method="POST" class="modal-box bg-base-100 text-white">
                                                    @csrf
                                                    @method('PUT')
                                                    <h3 class="modal-title capitalize text-white">Edit Proposal</h3>
                                                    <div class="modal-body">
                                                        @php
                                                            $fields = [
                                                                'no_urut' => [
                                                                    'type' => 'number',
                                                                    'label' => 'No Urut',
                                                                    'placeholder' => 'Masukkan No urut...',
                                                                    'value' => $item->no_urut,
                                                                ],
                                                                'tanggal' => [
                                                                    'type' => 'date',
                                                                    'label' => 'Tanggal',
                                                                    'placeholder' => 'Masukkan tanggal...',
                                                                    'value' => $item->tanggal_keluar,
                                                                ],
                                                                'perihal' => [
                                                                    'type' => 'text',
                                                                    'label' => 'Perihal',
                                                                    'placeholder' => 'Masukkan perihal...',
                                                                    'value' => $item->perihal,
                                                                ],
                                                                'file' => [
                                                                    'type' => 'file',
                                                                    'label' => 'File',
                                                                    'placeholder' => 'Masukkan file...',
                                                                    'value' => '', // file should not pre-fill for security reasons
                                                                ],
                                                            ];
                                                        @endphp

                                                        @foreach ($fields as $field => $attributes)
                                                            <div class="mt-4">
                                                                <label for="{{ $field }}"
                                                                    class="block mb-2 text-sm font-medium text-white">{{ $attributes['label'] }}:</label>
                                                                <input type="{{ $attributes['type'] }}"
                                                                    name="{{ $field }}"
                                                                    id="{{ $field }}"
                                                                    class="input input-bordered w-full text-white"
                                                                    placeholder="{{ $attributes['placeholder'] }}"
                                                                    required
                                                                    value="{{ old($field, $attributes['value']) }}">
                                                                @error($field)
                                                                    <span
                                                                        class="validated text-red-500 text-sm">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                        <div class="modal-action">
                                                            <button type="button"
                                                                onclick="document.getElementById('update_modal_{{ $item->id }}').close()"
                                                                class="btn btn-error capitalize">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary capitalize">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="font-semibold uppercase text-center text-gray-400" colspan="6">
                                            Tidak ada data proposal keluar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        @endforeach
        <dialog id="tambah_proposal_modal" class="modal modal-bottom sm:modal-middle">
            <form action="{{ route('store.proposal_keluar') }}" method="POST" enctype="multipart/form-data"
                class="modal-box bg-base-100 text-white">
                @csrf
                <h3 class="modal-title capitalize text-white">Tambah Proposal</h3>
                <div class="modal-body">
                    @php
                        $fields = [
                            'no_urut' => [
                                'type' => 'number',
                                'label' => 'No Urut',
                                'placeholder' => 'Masukkan No urut...',
                            ],
                            'tanggal' => [
                                'type' => 'date',
                                'label' => 'Tanggal',
                                'placeholder' => 'Masukkan tanggal...',
                            ],
                            'perihal' => [
                                'type' => 'text',
                                'label' => 'Perihal',
                                'placeholder' => 'Masukkan perihal...',
                            ],
                        ];
                    @endphp

                    @foreach ($fields as $field => $attributes)
                        <div class="mt-4">
                            <label for="{{ $field }}"
                                class="block mb-2 text-sm font-medium text-white">{{ $attributes['label'] }}:</label>
                            <input type="{{ $attributes['type'] }}" name="{{ $field }}"
                                id="{{ $field }}" class="input input-bordered w-full text-white"
                                placeholder="{{ $attributes['placeholder'] }}" required>
                            @error($field)
                                <span class="validated text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach

                    <!-- File Input Section -->
                    <div class="mt-4">
                        <label for="file" class="block mb-2 text-sm font-medium text-white">File:</label>
                        <input type="file" id="file" name="file" class="hidden"
                            onchange="previewFile()">
                        <label id="file_label" for="file"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                            Pilih File
                        </label>
                        <!-- Area for preview -->
                        <div id="file_preview" class="mt-3"></div>
                        <span class="validated text-red-500 text-sm" id="file_error"></span>
                    </div>

                    <div class="modal-action">
                        <button type="button" onclick="document.getElementById('tambah_proposal_modal').close()"
                            class="btn btn-error capitalize">Batal</button>
                        <button type="submit" class="btn btn-primary capitalize">Simpan</button>
                    </div>
                </div>
            </form>
        </dialog>

        <script>
            function previewFile() {
                const fileInput = document.getElementById('file');
                const fileLabel = document.getElementById('file_label');
                const filePreview = document.getElementById('file_preview');
                const file = fileInput.files[0];
        
                // Clear previous preview content
                filePreview.innerHTML = '';
        
                if (file) {
                    const fileType = file.type;
                    const blobUrl = URL.createObjectURL(file);
        
                    // Update label with file name
                    fileLabel.textContent = file.name;
        
                    // Determine file type and create appropriate preview
                    if (fileType.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = blobUrl;
                        img.alt = 'Preview Gambar';
                        img.classList.add('w-full', 'h-auto', 'rounded-lg', 'mt-2');
                        filePreview.appendChild(img);
                    } else if (fileType.startsWith('application/pdf')) {
                        const embed = document.createElement('embed');
                        embed.src = blobUrl;
                        embed.type = 'application/pdf';
                        embed.classList.add('w-full', 'h-64', 'mt-2');
                        filePreview.appendChild(embed);
                    } else if (fileType.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.src = blobUrl;
                        video.controls = true;
                        video.classList.add('w-full', 'h-auto', 'rounded-lg', 'mt-2');
                        filePreview.appendChild(video);
                    } else {
                        // For unsupported file types
                        const info = document.createElement('p');
                        info.textContent = `File dipilih: ${file.name}`;
                        filePreview.appendChild(info);
                    }
        
                    // Reset the file input after handling preview to allow re-selection of the same file
                    fileInput.value = '';
                } else {
                    // Reset if no file is selected
                    fileLabel.textContent = 'Pilih File';
                }
            }
        </script>
        
    </div>

</x-dashboard.main>
