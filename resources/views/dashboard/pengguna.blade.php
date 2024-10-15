<x-dashboard.main title="Kelola Pengguna">
    <div class="flex flex-col lg:flex-row gap-5">
        @foreach (['tambah_pengguna'] as $item)
            <div onclick="{{ $item . '_modal' }}.showModal()"
                class="flex items-center justify-between p-5 sm:p-7 hover:shadow-lg hover:bg-gray-700 active:scale-95 transition-all duration-200 ease-in-out border border-gray-600 bg-gray-800 cursor-pointer rounded-xl w-full">
                <div>
                    <h1
                        class="flex items-start gap-3 font-semibold font-sans text-base sm:text-lg capitalize text-gray-200">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>
                    <span class="block mt-1 text-sm text-gray-400 leading-relaxed">
                        Tambahkan pengguna baru.
                    </span>
                </div>
                <x-lucide-plus class="{{ $item == 'tambah_pengguna' ? '' : 'hidden' }} size-5 sm:size-7 text-gray-400" />
            </div>
        @endforeach
    </div>
    <div class="flex gap-5">
        @foreach (['Daftar_pengguna'] as $item)
            <div class="flex flex-col border border-gray-700 rounded-xl w-full bg-base-200 shadow-lg">
                <div class="p-5 sm:p-7 bg-base-300 rounded-t-xl">
                    <h1 class="flex items-start gap-3 font-semibold text-lg capitalize text-gray-200">
                        {{ str_replace('_', ' ', $item) }}
                    </h1>

                </div>
                <div class="flex flex-col bg-base-900 rounded-b-xl gap-3 divide-y divide-gray-600 pt-0 p-5 sm:p-7">
                    <div class="overflow-x-auto">
                        <table class="table w-full text-gray-300">
                            <thead>
                                <tr class="bg-base-300">
                                    @foreach (['No', 'Nama', 'email', 'role'] as $header)
                                        <th class="uppercase font-bold text-gray-400">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $i => $item)
                                    <tr class="hover:bg-base-200 transition duration-300">
                                        <th class="font-semibold text-gray-300">{{ $i + 1 }}</th>
                                        <td class="font-semibold uppercase">{{ $item->nama }}</td>
                                        <td class="font-semibold uppercase">{{ $item->email }}</td>
                                        <td class="font-semibold uppercase">{{ $item->role }}</td>

                                        <td class="flex space-x-2">
                                            <x-lucide-trash class="size-5 hover:stroke-red-500 cursor-pointer"
                                                aria-label="Delete Proposal"
                                                onclick="document.getElementById('delete_modal_{{ $item->id }}').showModal();" />

                                            <!-- Delete Modal -->
                                            <dialog id="delete_modal_{{ $item->id }}"
                                                class="modal modal-bottom sm:modal-middle">
                                                <form action="{{ route('delete.pengguna', $item->id) }}"
                                                    method="POST" class="modal-box bg-base-100 text-gray-900">
                                                    @csrf
                                                    @method('DELETE')
                                                    <h3 class="modal-title capitalize text-white">Konfirmasi Penghapusan
                                                    </h3>
                                                    <div class="modal-body text-white">
                                                        <p>Apakah Anda yakin ingin menghapus pengguna terkait.</p>
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

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="font-semibold uppercase text-center text-gray-400" colspan="6">
                                            Tidak ada data pengguna
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        @endforeach
        <dialog id="tambah_pengguna_modal" class="modal modal-bottom sm:modal-middle">
            <form action="{{ route('store.pengguna') }}" method="POST" enctype="multipart/form-data"
                class="modal-box bg-base-100 text-white">
                @csrf
                <h3 class="modal-title capitalize text-white">Tambah Pengguna</h3>
                <div class="modal-body">
                    @php
                        $fields = [
                            'nama' => [
                                'type' => 'text',
                                'label' => 'Nama Pengguna',
                                'placeholder' => 'Masukkan Nama Pengguna...',
                            ],
                            'email' => [
                                'type' => 'email',
                                'label' => 'Email Pengguna',
                                'placeholder' => 'Masukkan Email Pengguna...',
                            ],
                            'password' => [
                                'type' => 'password',
                                'label' => 'Password',
                                'placeholder' => 'Masukkan Password...',
                            ],
                            'role' => [
                                'type' => 'select',
                                'label' => 'Role Pengguna',
                                'options' => ['admin' => 'Admin', 'user' => 'User'],
                            ],
                        ];
                    @endphp

                    @foreach ($fields as $field => $attributes)
                        <div class="mt-4">
                            <label for="{{ $field }}"
                                class="block mb-2 text-sm font-medium text-white">{{ $attributes['label'] }}:</label>
                            @if ($attributes['type'] === 'select')
                                <select name="{{ $field }}" id="{{ $field }}"
                                    class="input input-bordered w-full text-white" required>
                                    @foreach ($attributes['options'] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="{{ $attributes['type'] }}" name="{{ $field }}"
                                    id="{{ $field }}" class="input input-bordered w-full text-white"
                                    placeholder="{{ $attributes['placeholder'] }}" required>
                            @endif
                            @error($field)
                                <span class="validated text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach

                    <div class="modal-action">
                        <button type="button" onclick="document.getElementById('tambah_pengguna_modal').close()"
                            class="btn btn-error capitalize">Batal</button>
                        <button type="submit" class="btn btn-primary capitalize">Simpan</button>
                    </div>
                </div>
            </form>
        </dialog>
    </div>
</x-dashboard.main>
