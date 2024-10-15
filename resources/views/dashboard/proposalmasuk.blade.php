<x-dashboard.main title="Proposal Masuk">
    <div class="grid gap-5 md:gap-6">
        <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
            <div class="bg-primary p-3 mr-4 text-white rounded-full flex items-center justify-center">
                <x-lucide-mail class="w-6 h-6" />
            </div>
            <div class="flex-grow">
                <p class="text-sm font-medium capitalize text-base-content">
                    Jumlah proposal Masuk
                </p>
            </div>
            <span class="ml-auto text-lg font-semibold text-base-content">{{ $jumlah_proposal_masuk ?? '0' }}</span>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-5 md:gap-6">
        @foreach (['proposal_terbaru', 'waktu_terdaftar'] as $type)
            <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
                <div
                    class="p-3 mr-4 text-white rounded-full flex items-center justify-center
                        {{ $type == 'proposal_terbaru' ? 'bg-warning' : '' }}
                        {{ $type == 'waktu_terdaftar' ? 'bg-accent' : '' }}">
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
        <div class="flex flex-col border border-gray-700 rounded-xl w-full bg-base-200 shadow-lg">
            <div class="p-5 sm:p-7 bg-base-300 rounded-t-xl">
                <h1 class="flex items-start gap-3 font-semibold text-lg capitalize text-gray-200">
                    Daftar Proposal
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
                                @foreach (['No', 'No Urut', 'Tanggal', 'Perihal', 'Aksi'] as $header)
                                    <th class="uppercase font-bold text-gray-400">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($proposal_masuk as $i => $item)
                                <tr class="hover:bg-base-200 transition duration-300">
                                    <th class="font-semibold text-gray-300">{{ $i + 1 }}</th>
                                    <td class="font-semibold uppercase">{{ $item->no_urut }}</td>
                                    <td class="font-semibold uppercase">{{ $item->tanggal_masuk }}</td>
                                    <td class="font-semibold uppercase">{{ $item->perihal }}</td>
                                    <td class="flex space-x-2">
                                        <x-lucide-pencil class="size-5 hover:stroke-yellow-500 cursor-pointer"
                                            onclick="document.getElementById('edit_modal_{{ $item->id }}').showModal();" />
                                        <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                            onclick="document.getElementById('delete_modal_{{ $item->id }}').showModal();" />
                                        <!-- Edit Modal -->
                                        <dialog id="edit_modal_{{ $item->id }}"
                                            class="modal modal-bottom sm:modal-middle">
                                            <form action="{{ route('update.proposal_masuk', $item->id) }}"
                                                method="POST" class="modal-box bg-base-100 text-white">
                                                @csrf
                                                @method('PUT')
                                                <h3 class="modal-title capitalize text-white">Edit Proposal</h3>
                                                <div class="modal-body">
                                                    @php
                                                        $fields = [
                                                            'no_urut' => 'No Urut',
                                                            'tanggal_masuk' => 'Tanggal',
                                                            'perihal' => 'Perihal',
                                                        ];
                                                    @endphp

                                                    @foreach ($fields as $field => $label)
                                                        <div class="mt-4">
                                                            <label for="{{ $field }}"
                                                                class="block mb-2 text-sm font-medium text-white">{{ $label }}:</label>
                                                            <input type="text" name="{{ $field }}"
                                                                id="{{ $field }}"
                                                                class="input input-bordered w-full text-white"
                                                                placeholder="Masukan {{ strtolower($label) }}..."
                                                                required value="{{ old($field, $item->$field) }}">
                                                            @error($field)
                                                                <span
                                                                    class="validated text-red-500 text-sm">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endforeach
                                                    <div class="modal-action">
                                                        <button type="button"
                                                            onclick="document.getElementById('edit_modal_{{ $item->id }}').close()"
                                                            class="btn btn-error capitalize">Batal</button>
                                                        <button type="submit"
                                                            class="btn btn-primary capitalize">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </dialog>

                                        <!-- Delete Modal -->
                                        <dialog id="delete_modal_{{ $item->id }}"
                                            class="modal modal-bottom sm:modal-middle">
                                            <form action="{{ route('delete.proposal_masuk', $item->id) }}"
                                                method="POST" class="modal-box bg-base-100 text-white">
                                                @csrf
                                                @method('DELETE')
                                                <h3 class="modal-title text-red-500">Hapus Proposal</h3>
                                                <p class="mt-4 text-white">Apakah Anda yakin ingin menghapus proposal
                                                    <strong>{{ $item->no_urut }}</strong>?
                                                </p>
                                                <div class="modal-action">
                                                    <button type="button"
                                                        onclick="document.getElementById('delete_modal_{{ $item->id }}').close()"
                                                        class="btn btn-error capitalize">Batal</button>
                                                    <button type="submit"
                                                        class="btn btn-primary capitalize">Hapus</button>
                                                </div>
                                            </form>
                                        </dialog>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="font-semibold uppercase text-center text-gray-400" colspan="5">
                                        Tidak ada proposal yang tersedia dalam arsip saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <dialog id="tambah_proposal_modal" class="modal modal-bottom sm:modal-middle">
        <form action="{{ route('store.proposal_masuk') }}" method="POST" class="modal-box bg-base-100 text-white">
            @php
                $fields = [
                    'no_urut' => 'No Urut',
                    'tanggal' => 'Tanggal',
                    'perihal' => 'Perihal',
                ];
            @endphp
            @csrf
            <h3 class="modal-title capitalize text-white">Tambah Proposal</h3>
            <div class="modal-body">
                @foreach ($fields as $field => $label)
                    <div class="mt-4">
                        <label for="{{ $field }}" class="block mb-2 text-sm font-medium text-white">{{ $label }}:</label>
                        @if ($field === 'tanggal')
                            <input type="date" name="{{ $field }}" id="{{ $field }}"
                                class="input input-bordered w-full text-white"
                                placeholder="Masukan {{ strtolower($label) }}..." required>
                        @else
                            <input type="text" name="{{ $field }}" id="{{ $field }}"
                                class="input input-bordered w-full text-white"
                                placeholder="Masukan {{ strtolower($label) }}..." required>
                        @endif
                        @error($field)
                            <span class="validated text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
                <div class="modal-action">
                    <button type="button" onclick="document.getElementById('tambah_proposal_modal').close()"
                        class="btn btn-error capitalize">Batal</button>
                    <button type="submit" class="btn btn-primary capitalize">Simpan</button>
                </div>
            </div>
        </form>
    </dialog>
    
</x-dashboard.main>