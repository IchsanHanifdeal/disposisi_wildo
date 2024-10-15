<x-dashboard.main title="Dashboard">
    <div class="grid gap-5 md:gap-6">
        <!-- Waktu Sekarang -->
        <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
            <div class="bg-primary p-3 mr-4 text-white rounded-full">
                <x-lucide-clock class="w-6 h-6"/>
            </div>
            <p class="text-sm font-medium capitalize text-base-content">
                Waktu
            </p>
            <span class="ml-auto text-lg font-semibold text-base-content">{{ date('d-m-y H:i') }}</span>
        </div>
    </div>

    <div class="grid sm:grid-cols-1 xl:grid-cols-2 gap-5 md:gap-6">
        @foreach (['jumlah_surat_masuk', 'jumlah_surat_keluar', 'jumlah_proposal_masuk', 'jumlah_proposal_keluar'] as $type)
            <div class="flex items-center px-4 py-3 bg-base-100 border border-base-300 rounded-xl shadow-sm">
                <!-- Icon for each type -->
                <div class="
                    p-3 mr-4 text-white rounded-full flex items-center justify-center
                    {{ $type == 'jumlah_surat_masuk' ? 'bg-blue-300' : '' }}
                    {{ $type == 'jumlah_surat_keluar' ? 'bg-green-300' : '' }}
                    {{ $type == 'jumlah_proposal_masuk' ? 'bg-red-300' : '' }}
                    {{ $type == 'jumlah_proposal_keluar' ? 'bg-yellow-300' : '' }}
                ">
                    @if ($type == 'jumlah_surat_masuk')
                        <x-lucide-mail class="w-6 h-6"/>
                    @elseif ($type == 'jumlah_surat_keluar')
                        <x-lucide-send class="w-6 h-6"/>
                    @elseif ($type == 'jumlah_proposal_masuk')
                        <x-lucide-file-text class="w-6 h-6"/>
                    @elseif ($type == 'jumlah_proposal_keluar')
                        <x-lucide-file-check class="w-6 h-6"/>
                    @endif
                </div>

                <!-- Information for each type -->
                <div>
                    <p class="text-sm font-medium capitalize text-base-content">
                        {{ str_replace('_', ' ', $type) }}
                    </p>
                    <p id="{{ $type }}" class="text-lg font-semibold text-base-content">
                        {{ $type == 'jumlah_surat_masuk' ? $jumlah_surat_masuk ?? '0' : '' }}
                        {{ $type == 'jumlah_surat_keluar' ? $jumlah_surat_keluar ?? '0' : '' }}
                        {{ $type == 'jumlah_proposal_masuk' ? $jumlah_proposal_masuk ?? '0' : '' }}
                        {{ $type == 'jumlah_proposal_keluar' ? $jumlah_proposal_keluar ?? '0' : '' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard.main>
