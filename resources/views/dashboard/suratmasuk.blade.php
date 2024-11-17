<x-dashboard.main title="Surat Masuk">
    <div class="grid gap-5 md:gap-6">
        <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
            <div class="bg-primary p-3 mr-4 text-white rounded-full flex items-center justify-center">
                <x-lucide-mail class="w-6 h-6" />
            </div>
            <div class="flex-grow">
                <p class="text-sm font-medium capitalize text-base-content">
                    Jumlah Surat Masuk
                </p>
            </div>
            <span class="ml-auto text-lg font-semibold text-base-content">{{ $jumlah_surat_masuk ?? '0' }}</span>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-5 md:gap-6">
        @foreach (['surat_terbaru', 'waktu_terdaftar'] as $type)
            <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
                <div
                    class="
                    p-3 mr-4 text-white rounded-full flex items-center justify-center
                    {{ $type == 'surat_terbaru' ? 'bg-warning' : '' }}
                    {{ $type == 'waktu_terdaftar' ? 'bg-accent' : '' }}
                ">
                    @if ($type == 'surat_terbaru')
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
                        {{ $type == 'surat_terbaru' ? $surat_terbaru ?? '-' : '' }}
                        {{ $type == 'waktu_terdaftar' ? $waktu_terdaftar ?? '-' : '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex flex-col lg:flex-row gap-5">
        @foreach (['tambah_surat'] as $item)
            <div onclick="{{ $item . '_modal' }}.showModal()"
                class="flex items-center justify-between p-5 sm:p-7 hover:shadow-lg hover:bg-gray-700 active:scale-95 transition-all duration-200 ease-in-out border border-gray-600 bg-gray-800 cursor-pointer rounded-xl w-full">
                <div>
                    <h1
                        class="flex items-start gap-3 font-semibold font-sans text-base sm:text-lg capitalize text-gray-200">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <span class="block mt-1 text-sm text-gray-400 leading-relaxed">
                        Tambahkan surat baru dengan mudah dan kelola data rekap secara efisien.
                    </span>
                </div>
                <x-lucide-plus class="{{ $item == 'tambah_surat' ? '' : 'hidden' }} size-5 sm:size-7 text-gray-400" />
            </div>
        @endforeach
    </div>
    <div class="flex gap-5">
        @foreach (['Daftar_surat'] as $item)
            <div class="flex flex-col border border-gray-700 rounded-xl w-full bg-base-200 shadow-lg">
                <div class="p-5 sm:p-7 bg-base-300 rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold text-lg capitalize text-gray-200">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <p class="text-sm text-gray-400">
                        Temukan semua surat yang telah terdaftar dan kelola data dengan mudah di sini.
                    </p>
                </div>
                <div class="flex flex-col rounded-b-xl gap-3 divide-y divide-gray-600 pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table w-full text-gray-300">
                            <thead>
                                <tr class="bg-base-300">
                                    @foreach (['No', 'No Urut', 'Tanggal', 'File', 'Jenis Surat', 'Tujuan', 'Perihal', 'Aksi'] as $header)
                                        <th class="uppercase font-bold text-gray-400">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($surat_masuk as $i => $item)
                                    <tr class="hover:bg-base-200 transition duration-300">
                                        <th class="font-semibold text-gray-300">{{ $i + 1 }}</th>
                                        <td class="font-semibold uppercase">{{ $item->no_urut }}</td>
                                        <td class="font-semibold uppercase">{{ $item->tanggal_masuk }}</td>
                                        <td class="flex items-center">
                                            <button type="button"
                                                class="btn btn-primary w-full sm:w-auto px-4 py-2 text-sm font-medium rounded-lg shadow-md hover:bg-primary-focus focus:outline-none focus:ring-2 focus:ring-primary-focus focus:ring-offset-2 transition-all duration-300"
                                                aria-label="Preview Proposal"
                                                onclick="document.getElementById('preview_modal_{{ $item->id }}').showModal();">
                                                Lihat
                                            </button>

                                            <dialog id="preview_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <div class="modal-box bg-neutral text-white">
                                                    <h3 class="text-lg font-bold" id="modal-title">{{ $item->no_urut }}
                                                    </h3>
                                                    <div
                                                        class="flex flex-col w-full mt-3 rounded-lg overflow-hidden h-96">
                                                        <embed
                                                            src="{{ asset('storage/' . $item->file) }}"
                                                            type="application/pdf" class="w-full h-full" />

                                                    </div>
                                                    <div class="modal-action">
                                                        <button type="button"
                                                            onclick="document.getElementById('preview_modal_{{ $item->id }}').close()"
                                                            class="btn">Tutup</button>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </td>
                                        <td class="font-semibold uppercase">{{ $item->jenis_surat }}</td>
                                        <td class="font-semibold uppercase">{{ $item->tujuan }}</td>
                                        <td class="font-semibold uppercase">{{ $item->perihal }}</td>
                                        <td class="flex space-x-2">
                                            <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                                onclick="document.getElementById('update_modal_{{ $item->id }}').showModal();" />
                                            <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                                onclick="document.getElementById('delete_modal_{{ $item->id }}').showModal();" />
                                            <!-- Delete Modal -->
                                            <dialog id="delete_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <form action="{{ route('delete.surat_masuk', $item->id) }}"
                                                    method="POST" class="modal-box bg-base-100 text-gray-900">
                                                    @csrf
                                                    @method('DELETE')
                                                    <h3 class="modal-title capitalize text-white">Konfirmasi Penghapusan
                                                    </h3>
                                                    <div class="modal-body text-white">
                                                        <p>Apakah Anda yakin ingin menghapus surat ini? Tindakan ini
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
                                                <form action="{{ route('update.surat_masuk', $item->id) }}"
                                                    method="POST" class="modal-box bg-base-100 text-white">
                                                    @csrf
                                                    @method('PUT')
                                                    <h3 class="modal-title capitalize text-white">Edit Surat</h3>
                                                    <div class="modal-body">
                                                        @php
                                                            $fields = [
                                                                'no_urut' => [
                                                                    'type' => 'number',
                                                                    'label' => 'No Urut',
                                                                    'placeholder' => 'Masukan No urut...',
                                                                    'value' => $item->no_urut,
                                                                ],
                                                                'tanggal_masuk' => [
                                                                    'type' => 'date',
                                                                    'label' => 'Tanggal Masuk',
                                                                    'placeholder' => 'Masukan tanggal masuk...',
                                                                    'value' => $item->tanggal_masuk,
                                                                ],
                                                                'tujuan' => [
                                                                    'type' => 'text',
                                                                    'label' => 'Tujuan',
                                                                    'placeholder' => 'Masukan tujuan...',
                                                                    'value' => $item->tujuan,
                                                                ],
                                                                'perihal' => [
                                                                    'type' => 'text',
                                                                    'label' => 'Perihal',
                                                                    'placeholder' => 'Masukan perihal...',
                                                                    'value' => $item->perihal,
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
                                            Tidak ada surat yang tersedia dalam arsip saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @foreach (['tambah_surat'] as $item)
        @php
            $type = explode('_', $item)[0];

            $fields = [
                'no_urut' => [
                    'type' => 'number',
                    'label' => 'No Urut',
                    'placeholder' => 'Masukan No urut...',
                ],
                'tanggal_masuk' => [
                    'type' => 'date',
                    'label' => 'Tanggal Masuk',
                    'placeholder' => 'Masukan tanggal masuk...',
                ],
                'tujuan' => [
                    'type' => 'text',
                    'label' => 'Tujuan',
                    'placeholder' => 'Masukan tujuan...',
                ],
                'perihal' => [
                    'type' => 'text',
                    'label' => 'Perihal',
                    'placeholder' => 'Masukan perihal...',
                ],
            ];
        @endphp
        <dialog id="{{ $item }}_modal" class="modal modal-bottom sm:modal-middle">
            <form action="{{ route('store.surat_masuk') }}" method="POST" enctype="multipart/form-data"
                class="modal-box bg-base-100 text-gray-900">
                @csrf
                <h3 class="modal-title capitalize text-white">
                    {{ str_replace('_', ' ', $item) }}
                </h3>
                <div class="modal-body">
                    <div>
                        <label for="jenis_surat" class="block mb-2 text-sm font-medium text-white">Jenis
                            Surat</label>
                        <select id="jenis_surat" name="jenis_surat" class="select select-bordered w-full text-white">
                            <option value="">--- Pilih Jenis Surat ---</option>
                            <option value="undangan">Undangan</option>
                            <option value="permohonan">Permohonan</option>
                            <option value="pemberitahuan">Pemberitahuan</option>
                        </select>
                        @error('jenis_surat')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    @foreach ($fields as $field => $attributes)
                        <div class="mt-4">
                            <label for="{{ $field }}"
                                class="block mb-2 text-sm font-medium text-white">{{ $attributes['label'] }}:</label>
                            <input type="{{ $attributes['type'] }}" name="{{ $field }}"
                                id="{{ $field }}" class="input input-bordered w-full text-white"
                                placeholder="{{ $attributes['placeholder'] }}" required value="{{ old($field) }}">
                            @error($field)
                                <span class="validated text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach

                    <div class="mt-4">
                        <label for="file" class="block mb-2 text-sm font-medium text-white">File (PDF):</label>
                        <input type="file" id="file" name="file"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg cursor-pointer focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 text-center"
                            accept="application/pdf" onchange="handleFileChange(event)">
                        <div id="file_preview" class="mt-3"></div>
                        <span id="file_error" class="validated text-red-500 text-sm"></span>
                    </div>

                    <div class="modal-action">
                        <button type="button" onclick="document.getElementById('{{ $item }}_modal').close()"
                            class="btn btn-error capitalize">Batal</button>
                        <button type="submit" class="btn btn-primary capitalize">Simpan</button>
                    </div>
                </div>
            </form>
        </dialog>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const filePreview = document.getElementById('file_preview');
            const fileError = document.getElementById('file_error');
            const fileLabel = document.getElementById('file_label');
            const maxFileSizeMB = 2;

            // Handle file input change
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                // Reset preview and error message
                filePreview.innerHTML = '';
                fileError.textContent = '';

                if (file) {
                    // Validate file type
                    if (file.type !== 'application/pdf') {
                        fileError.textContent = 'File harus berupa PDF!';
                        fileLabel.textContent = 'Pilih File'; // Reset label if error
                        fileInput.value = ''; // Reset input value if invalid file
                        return;
                    }

                    // Validate file size
                    if (file.size > maxFileSizeMB * 1024 * 1024) {
                        fileError.textContent = `Ukuran file terlalu besar! Maksimal ${maxFileSizeMB} MB.`;
                        fileLabel.textContent = 'Pilih File'; // Reset label if error
                        fileInput.value = ''; // Reset input value if invalid size
                        return;
                    }

                    // Update label text to show selected file name
                    fileLabel.textContent = `File: ${file.name}`;

                    // Generate PDF preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.innerHTML = `
                <iframe src="${e.target.result}" width="100%" height="400px"
                    class="rounded-lg border border-gray-300"></iframe>
            `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Reset state if no file is selected
                    fileError.textContent = 'Tidak ada file yang dipilih!';
                    fileLabel.textContent = 'Pilih File';
                }
            });

            // Reset label and error when file input is cleared manually
            fileInput.addEventListener('click', function() {
                if (!fileInput.value) {
                    fileError.textContent = '';
                    fileLabel.textContent = 'Pilih File';
                    filePreview.innerHTML = '';
                }
            });

            // Reset label on label click
            fileLabel.addEventListener('click', function() {
                fileError.textContent = ''; // Reset error on label click
            });
        });
    </script>

</x-dashboard.main>
