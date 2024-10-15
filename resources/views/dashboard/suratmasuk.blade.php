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
                                    @foreach (['No', 'No Urut', 'Tanggal', 'Jenis Surat', 'Tujuan', 'Perihal', 'Aksi'] as $header)
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
                    <div class="modal-action">
                        <button type="button" onclick="document.getElementById('{{ $item }}_modal').close()"
                            class="btn btn-error capitalize">Batal</button>
                        <button type="submit" class="btn btn-primary capitalize">Simpan</button>
                    </div>
                </div>
            </form>
        </dialog>
    @endforeach

</x-dashboard.main>
