<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem PRB - Puskesmas Purwanegara 1')</title>

    <!-- Fonts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery dan Select2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('styles')
</head>
<body class="h-full bg-gray-100">
    <!-- Mobile Menu -->
    <div class="md:hidden bg-white border-b fixed top-0 left-0 right-0 z-50">
        <div class="flex items-center justify-between h-16 px-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/banjar.png') }}" alt="Logo" class="h-8">
                <span class="text-lg font-semibold text-gray-800">Sistem PRB</span>
            </a>
            <button type="button" id="mobile-menu-button" class="p-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
        </div>
    </div>

    <!-- Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <!-- Sidebar Header (hanya tampil di desktop) -->
        <div class="hidden md:flex items-center p-4 border-b border-gray-200">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/banjar.png') }}" alt="Logo" class="h-10 mr-3">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Sistem PRB</h1>
                    <p class="text-xs text-gray-500">Puskesmas Purwanegara 1</p>
                </div>
            </a>
        </div>

        <!-- Mobile Only: User Info, Search, Notif -->
        <div class="md:hidden px-4 pt-6 pb-4 border-b-2 border-blue-200 bg-blue-50">
            <div class="flex items-center gap-3 mb-2" x-data="{ open: false }">
                @auth
                <img class="w-12 h-12 rounded-full ring-2 ring-blue-300" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=6366f1&color=fff" alt="User avatar">
                <div class="relative">
                    <button @click="open = !open" class="text-left focus:outline-none">
                        <div class="font-semibold text-blue-900 text-base">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-blue-700">{{ Auth::user()->email }}</div>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                        class="absolute left-0 mt-2 w-44 bg-white rounded-lg shadow-lg py-2 z-50 border border-blue-100">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-2"></i> Profil
                        </a>
                        <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i> Pengaturan
                        </a>
                        <hr class="my-1 border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>

        <!-- Navigation (scrollable) -->
        <div class="overflow-y-auto h-[calc(100vh-64px)]">
            <nav class="mt-4 px-3">
                <!-- Dashboard -->
                <a href="{{ route('home') }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('home') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-home w-5 h-5 mr-3 text-gray-500"></i>
                    Dashboard
                </a>

                <!-- Pengambilan Obat -->
                <a href="{{ route('medicines.take') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('medicines/take') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-pills w-5 h-5 mr-3 text-gray-500"></i>
                    Pengambilan Obat
                </a>

                <!-- Pasien -->
                <a href="{{ route('patients.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('patients*') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-users w-5 h-5 mr-3 text-gray-500"></i>
                    Pasien
                </a>

                <!-- Resep -->
                <a href="{{ route('prescriptions.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('prescriptions*') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-prescription w-5 h-5 mr-3 text-gray-500"></i>
                    Resep
                </a>

                <!-- Obat -->
                <a href="{{ route('medicines.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('medicines') && !Request::is('medicines/take') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-capsules w-5 h-5 mr-3 text-gray-500"></i>
                    Obat
                </a>

                <!-- Penyakit -->
                <a href="{{ route('diseases.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('diseases*') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-virus w-5 h-5 mr-3 text-gray-500"></i>
                    Penyakit
                </a>

                <!-- Pasien PRB + Gejala Tambahan -->
                <a href="{{ route('prb-gejala.resep') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium rounded-lg hover:bg-blue-50 hover:text-blue-700 {{ Request::is('prb-gejala/resep*') ? 'bg-blue-100 text-blue-700' : 'text-gray-900' }}">
                    <i class="fas fa-user-md w-5 h-5 mr-3 {{ Request::is('prb-gejala/resep*') ? 'text-blue-700' : 'text-gray-500' }}"></i>
                    Rekomendasi Obat
                </a>

                <!-- Menu Kelola Akun, hanya untuk admin -->
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('users*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-user-cog w-5 h-5 mr-3 text-gray-500"></i>
                            Kelola Akun
                        </a>
                        <a href="{{ route('doctors.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('doctors*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-user-md w-5 h-5 mr-3 text-gray-500"></i>
                            Kelola Dokter
                        </a>
                    @endif
                @endauth

                <hr class="my-4 border-gray-200">

                <!-- SPK -->
                <div x-data="{ open: {{ Request::is('kriteria*') || Request::is('matriks-kriteria*') || Request::is('perhitungan*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-cogs w-5 h-5 mr-3 text-gray-500"></i>
                            <span>SPK</span>
                        </div>
                        <i class="fas fa-chevron-down w-4 h-4 text-gray-500 transition-transform duration-200"
                           :class="{ 'transform rotate-180': open }"></i>
                    </button>

                    <div x-show="open" x-collapse class="mt-1 space-y-1 px-3 py-2">
                        <!-- Kelola Kriteria -->
                        <a href="{{ route('kriteria.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('kriteria*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-list-ul w-4 h-4 mr-2"></i>
                            Kelola Kriteria
                        </a>

                        <!-- Matriks Perbandingan Kriteria -->
                        <a href="{{ route('matriks-kriteria.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('matriks-kriteria*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-table w-4 h-4 mr-2"></i>
                            Matriks Perbandingan Kriteria
                        </a>

                        <!-- Hitung Bobot Kriteria -->
                        <a href="{{ route('perhitungan.bobot') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('perhitungan/bobot*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-calculator w-4 h-4 mr-2"></i>
                            Hitung Bobot Kriteria
                        </a>

                        <!-- Penilaian Obat Global -->
                        <a href="{{ route('penilaian-obat-global.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('penilaian-obat-global*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-clipboard-list w-4 h-4 mr-2 text-gray-600"></i>
                            Penilaian Obat Global
                        </a>

                        <!-- Penyakit Gejala Tambahan (SPK) -->
                        <a href="{{ route('penyakits.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('penyakits*') && !Request::is('penyakits/mapping*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-virus w-4 h-4 mr-2 text-gray-600"></i>
                            Penyakit Gejala Tambahan
                        </a>
                        <!-- Mapping Obat ke Penyakit (SPK) -->
                        <a href="{{ route('penyakits.mapping') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('penyakits/mapping*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-link w-4 h-4 mr-2 text-gray-600"></i>
                            Mapping Obat ke Penyakit
                        </a>

                        <!-- Hitung Skor Obat -->
                        <a href="{{ route('perhitungan.skor') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('perhitungan/skor*') ? 'bg-gray-100' : '' }}">
                            <i class="fas fa-chart-bar w-4 h-4 mr-2 text-gray-600"></i>
                            Hitung Skor Obat
                        </a>
                        <!-- Riwayat Rekomendasi SPK -->
                        <a href="{{ route('spk.riwayat-rekomendasi') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 {{ Request::is('spk/riwayat-rekomendasi*') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="fas fa-history w-4 h-4 mr-2 {{ Request::is('spk/riwayat-rekomendasi*') ? 'text-blue-700' : 'text-gray-600' }}"></i>
                            Riwayat Rekomendasi
                        </a>
                    </div>
                </div>

                <!-- Laporan -->
                <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('reports') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-file-alt w-5 h-5 mr-3 text-gray-500"></i>
                    Laporan
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="md:ml-64 min-h-screen">
        <!-- Top Navigation -->
        <div class="bg-white shadow-sm sticky top-0 z-40 hidden md:block">
            <div class="flex items-center justify-between h-16 px-4 md:px-6">
                <!-- Hanya tampil di desktop -->
                <div class="hidden md:flex flex-1 items-center justify-end space-x-4">
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                            <img class="w-8 h-8 rounded-full ring-2 ring-gray-200"
                                 src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=6366f1&color=fff"
                                 alt="User avatar">
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        </button>
                        <div x-show="open"
                             @click.away="open = false"
                             x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-2"></i> Profil
                            </a>
                            <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Pengaturan
                            </a>
                            <hr class="my-1 border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="p-6 pt-20 md:pt-6">
            @if(session('success'))
            <div class="mb-6 p-4 flex items-center bg-green-50 border border-green-200 rounded-lg">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 flex items-center bg-red-50 border border-red-200 rounded-lg">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Mobile Backdrop -->
    <div id="mobile-backdrop" class="fixed inset-0 bg-black/50 z-20 md:hidden" style="display: none;"></div>

    <!-- Sidebar Mobile (khusus mobile) -->
    <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>
    <div id="mobile-sidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg z-50 transform -translate-x-full transition-transform duration-300 md:hidden overflow-y-auto">
        <div class="flex items-center p-4 border-b border-gray-200">
            <img src="{{ asset('images/banjar.png') }}" alt="Logo" class="h-10 mr-3">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Sistem PRB</h1>
                <p class="text-xs text-gray-500">Puskesmas Purwanegara 1</p>
            </div>
        </div>
        <nav class="mt-4 px-3">
            <!-- Dashboard -->
            <a href="{{ route('home') }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('home') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-home w-5 h-5 mr-3 text-gray-500"></i>
                Dashboard
            </a>
            <!-- Pengambilan Obat -->
            <a href="{{ route('medicines.take') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('medicines/take') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-pills w-5 h-5 mr-3 text-gray-500"></i>
                Pengambilan Obat
            </a>
            <!-- Pasien -->
            <a href="{{ route('patients.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('patients*') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-users w-5 h-5 mr-3 text-gray-500"></i>
                Pasien
            </a>
            <!-- Resep -->
            <a href="{{ route('prescriptions.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('prescriptions*') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-prescription w-5 h-5 mr-3 text-gray-500"></i>
                Resep
            </a>
            <!-- Obat -->
            <a href="{{ route('medicines.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('medicines') && !Request::is('medicines/take') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-capsules w-5 h-5 mr-3 text-gray-500"></i>
                Obat
            </a>
            <!-- Penyakit -->
            <a href="{{ route('diseases.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('diseases*') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-virus w-5 h-5 mr-3 text-gray-500"></i>
                Penyakit
            </a>
            <!-- Pasien PRB + Gejala Tambahan -->
            <a href="{{ route('prb-gejala.resep') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium rounded-lg hover:bg-blue-50 hover:text-blue-700 {{ Request::is('prb-gejala/resep*') ? 'bg-blue-100 text-blue-700' : 'text-gray-900' }}">
                <i class="fas fa-user-md w-5 h-5 mr-3 {{ Request::is('prb-gejala/resep*') ? 'text-blue-700' : 'text-gray-500' }}"></i>
                Rekomendasi Obat
            </a>
            @auth
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('users*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-user-cog w-5 h-5 mr-3 text-gray-500"></i>
                        Kelola Akun
                    </a>
                    <a href="{{ route('doctors.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('doctors*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-user-md w-5 h-5 mr-3 text-gray-500"></i>
                        Kelola Dokter
                    </a>
                @endif
            @endauth
            <hr class="my-4 border-gray-200">
            <!-- SPK -->
            <div x-data="{ open: {{ Request::is('kriteria*') || Request::is('matriks-kriteria*') || Request::is('perhitungan*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-cogs w-5 h-5 mr-3 text-gray-500"></i>
                        <span>SPK</span>
                    </div>
                    <i class="fas fa-chevron-down w-4 h-4 text-gray-500 transition-transform duration-200"
                       :class="{ 'transform rotate-180': open }"></i>
                </button>
                <div x-show="open" x-collapse class="mt-1 space-y-1 px-3 py-2">
                    <a href="{{ route('kriteria.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('kriteria*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-list-ul w-4 h-4 mr-2"></i>
                        Kelola Kriteria
                    </a>
                    <a href="{{ route('matriks-kriteria.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('matriks-kriteria*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-table w-4 h-4 mr-2"></i>
                        Matriks Perbandingan Kriteria
                    </a>
                    <a href="{{ route('perhitungan.bobot') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('perhitungan/bobot*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-calculator w-4 h-4 mr-2"></i>
                        Hitung Bobot Kriteria
                    </a>
                    <a href="{{ route('penilaian-obat-global.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('penilaian-obat-global*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-clipboard-list w-4 h-4 mr-2 text-gray-600"></i>
                        Penilaian Obat Global
                    </a>
                    <a href="{{ route('penyakits.index') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('penyakits*') && !Request::is('penyakits/mapping*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-virus w-4 h-4 mr-2 text-gray-600"></i>
                        Penyakit Gejala Tambahan
                    </a>
                    <a href="{{ route('penyakits.mapping') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('penyakits/mapping*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-link w-4 h-4 mr-2 text-gray-600"></i>
                        Mapping Obat ke Penyakit
                    </a>
                    <a href="{{ route('perhitungan.skor') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 {{ Request::is('perhitungan/skor*') ? 'bg-gray-100' : '' }}">
                        <i class="fas fa-chart-bar w-4 h-4 mr-2 text-gray-600"></i>
                        Hitung Skor Obat
                    </a>
                    <!-- Riwayat Rekomendasi SPK -->
                    <a href="{{ route('spk.riwayat-rekomendasi') }}" class="flex items-center pl-8 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 {{ Request::is('spk/riwayat-rekomendasi*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-history w-4 h-4 mr-2 {{ Request::is('spk/riwayat-rekomendasi*') ? 'text-blue-700' : 'text-gray-600' }}"></i>
                        Riwayat Rekomendasi
                    </a>
                </div>
            </div>
            <!-- Laporan -->
            <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2.5 mt-1 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 {{ Request::is('reports') ? 'bg-gray-100' : '' }}">
                <i class="fas fa-file-alt w-5 h-5 mr-3 text-gray-500"></i>
                Laporan
            </a>
        </nav>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const mobileMenuButton = document.getElementById('mobile-menu-button');

            // Debug
            console.log('Sidebar element:', sidebar);
            console.log('Overlay element:', overlay);
            console.log('Menu button element:', mobileMenuButton);

            function openSidebar() {
                console.log('Opening sidebar');
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                console.log('Closing sidebar');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }

            // Event listener untuk tombol menu
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Menu button clicked');
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            // Event listener untuk overlay
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Overlay clicked');
                closeSidebar();
            });

            // Event listener untuk resize window
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                } else {
                    closeSidebar();
                }
            });

            const openBtn = document.getElementById('mobile-menu-button');
            const closeBtn = document.getElementById('close-mobile-sidebar');
            const sidebarMobile = document.getElementById('mobile-sidebar');
            const overlayMobile = document.getElementById('mobile-sidebar-overlay');

            function openSidebarMobile() {
                sidebarMobile.classList.remove('-translate-x-full');
                overlayMobile.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            function closeSidebarMobile() {
                sidebarMobile.classList.add('-translate-x-full');
                overlayMobile.classList.add('hidden');
                document.body.style.overflow = '';
            }
            if (openBtn) openBtn.addEventListener('click', openSidebarMobile);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebarMobile);
            if (overlayMobile) overlayMobile.addEventListener('click', closeSidebarMobile);
        });
    </script>
    @stack('scripts')
</body>
</html>
