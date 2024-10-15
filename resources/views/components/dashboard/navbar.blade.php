<div class="navbar bg-base-100 shadow-sm">
    <!-- Navbar Start -->
    <div class="navbar-start">
        <!-- Mobile Dropdown Menu -->
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <x-lucide-menu class="h-5 w-5" />
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <a href="{{ route('dashboard') }}" class="{!! Request::path() == 'dashboard' ? 'active' : '' !!}">
                        <x-lucide-gauge class="h-5 w-5 mr-2" />
                        Dashboard
                    </a>
                </li>
                @if (Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('pengguna') }}" class="{!! preg_match('#^dashboard/pengguna.*#', Request::path()) ? 'active' : '' !!}">
                            <x-lucide-users class="h-5 w-5 mr-2" />
                            Pengguna
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('pengguna') }}" class="{!! preg_match('#^dashboard/pengguna.*#', Request::path()) ? 'active' : '' !!}">
                        <x-lucide-users class="h-5 w-5 mr-2" />
                        Pengguna
                    </a>
                </li>
                <li>
                    <a href="{{ route('surat_masuk') }}" class="{!! preg_match('#^dashboard/suratmasuk.*#', Request::path()) ? 'active' : '' !!}">
                        <x-lucide-mail class="h-5 w-5 mr-2" />
                        Surat Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('surat_keluar') }}" class="{!! preg_match('#^dashboard/suratkeluar.*#', Request::path()) ? 'active' : '' !!}">
                        <x-lucide-send class="h-5 w-5 mr-2" />
                        Surat Keluar
                    </a>
                </li>
                <li>
                    <a href="{{ route('proposal_masuk') }}" class="{!! preg_match('#^dashboard/proposalmasuk.*#', Request::path()) ? 'active' : '' !!}">
                        <x-lucide-file-text class="h-5 w-5 mr-2" />
                        Proposal Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('proposal_keluar') }}" class="{!! preg_match('#^dashboard/proposalkeluar.*#', Request::path()) ? 'active' : '' !!}">
                        <x-lucide-file-check class="h-5 w-5 mr-2" />
                        Proposal Keluar
                    </a>
                </li>
            </ul>
        </div>
        <!-- Brand Logo -->
        <a class="btn btn-ghost text-xl uppercase" href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
    </div>

    <!-- Navbar Center for Large Screens -->
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li>
                <a class="{!! Request::path() == 'dashboard' ? 'active' : '' !!}" href="{{ route('dashboard') }}">
                    <x-lucide-gauge class="h-5 w-5 mr-2" />
                    Dashboard
                </a>
            </li>
            @if (Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('pengguna') }}" class="{!! preg_match('#^dashboard/pengguna.*#', Request::path()) ? 'active' : '' !!}">
                        <x-lucide-users class="h-5 w-5 mr-2" />
                        Pengguna
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('surat_masuk') }}" class="{!! preg_match('#^dashboard/suratmasuk.*#', Request::path()) ? 'active' : '' !!}">
                    <x-lucide-mail class="h-5 w-5 mr-2" />
                    Surat Masuk
                </a>
            </li>
            <li>
                <a href="{{ route('surat_keluar') }}" class="{!! preg_match('#^dashboard/suratkeluar.*#', Request::path()) ? 'active' : '' !!}">
                    <x-lucide-send class="h-5 w-5 mr-2" />
                    Surat Keluar
                </a>
            </li>
            <li>
                <a href="{{ route('proposal_masuk') }}" class="{!! preg_match('#^dashboard/proposalmasuk.*#', Request::path()) ? 'active' : '' !!}">
                    <x-lucide-file-text class="h-5 w-5 mr-2" />
                    Proposal Masuk
                </a>
            </li>
            <li>
                <a href="{{ route('proposal_keluar') }}" class="{!! preg_match('#^dashboard/proposalkeluar.*#', Request::path()) ? 'active' : '' !!}">
                    <x-lucide-file-check class="h-5 w-5 mr-2" />
                    Proposal Keluar
                </a>
            </li>
        </ul>
    </div>

    <!-- Navbar End - User Dropdown -->
    <div class="navbar-end">
        <div class="dropdown dropdown-end">
            <div tabindex="0" class="btn btn-ghost flex items-center">
                <img class="w-8 h-8 rounded-full border border-gray-400"
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}" alt="User Avatar">
                <span class="ml-2">{{ Auth::user()->nama }}</span>
            </div>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 mt-2">
                <dialog id="logout_confirm_modal" class="modal modal-bottom sm:modal-middle">
                    <form method="POST" action="{{ route('logout') }}"
                        class="modal-box bg-base-100 shadow-lg rounded-lg p-6">
                        @csrf
                        <h3 class="modal-title text-xl font-semibold text-gray-900 flex items-center">
                            <x-lucide-log-out class="h-6 w-6 text-white mr-2" />
                            Konfirmasi Logout
                        </h3>
                        <p class="text-white mt-2">Apakah Anda yakin ingin keluar dari akun Anda?</p>

                        <div class="modal-action mt-6 flex justify-between">
                            <button type="button" onclick="document.getElementById('logout_confirm_modal').close()"
                                class="btn btn-error capitalize hover:bg-red-600 transition duration-200">Batal</button>
                            <button type="submit"
                                class="btn btn-primary capitalize hover:bg-blue-600 transition duration-200">Logout</button>
                        </div>
                    </form>
                </dialog>

                <li>
                    <button onclick="document.getElementById('logout_confirm_modal').showModal()"
                        class="flex items-center">
                        <x-lucide-log-out class="h-5 w-5 mr-2" />
                        Logout
                    </button>
                </li>


            </ul>
        </div>
    </div>
</div>
