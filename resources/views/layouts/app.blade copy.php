<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem PRB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full bg-gray-100">
    <!-- Mobile Menu -->
    <div class="md:hidden bg-indigo-700 shadow-lg">
        <div class="flex items-center justify-between h-16 px-4">
            <span class="text-xl font-bold text-white">Sistem Program Rujuk Balik</span>
            <button id="mobile-menu-button" class="text-white p-2 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-white">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-2xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50">
        <div class="flex items-center justify-center h-16 bg-indigo-700">
            <span class="text-white text-xl font-bold tracking-wide">Sistem PRB</span>
        </div>

        <nav class="mt-6 px-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 {{ Request::is('home') ? 'bg-indigo-50 text-indigo-700 font-medium border-l-4 border-indigo-700' : '' }}">
                <i class="fas fa-tachometer-alt w-5 h-5 text-gray-400"></i>
                <span class="ml-4">Dashboard</span>
            </a>

            <!-- Pengambilan Obat -->
            <a href="{{ route('medicines.take') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 {{ Request::is('medicines/take') ? 'bg-indigo-50 text-indigo-700 font-medium border-l-4 border-indigo-700' : '' }}">
                <i class="fas fa-pills w-5 h-5 text-gray-400"></i>
                <span class="ml-4">Pengambilan Obat</span>
            </a>

            <!-- Pasien -->
            <a href="{{ route('patients.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 {{ Request::is('patients*') ? 'bg-indigo-50 text-indigo-700 font-medium border-l-4 border-indigo-700' : '' }}">
                <i class="fas fa-users w-5 h-5 text-gray-400"></i>
                <span class="ml-4">Pasien</span>
            </a>

            <!-- Resep -->
            <a href="{{ route('prescriptions.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 {{ Request::is('prescriptions*') ? 'bg-indigo-50 text-indigo-700 font-medium border-l-4 border-indigo-700' : '' }}">
                <i class="fas fa-prescription w-5 h-5 text-gray-400"></i>
                <span class="ml-4">Resep</span>
            </a>

            <!-- Obat -->
            <a href="{{ route('medicines.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 {{ Request::is('medicines') && !Request::is('medicines/take') ? 'bg-indigo-50 text-indigo-700 font-medium border-l-4 border-indigo-700' : '' }}">
                <i class="fas fa-pills w-5 h-5 text-gray-400"></i>
                <span class="ml-4">Obat</span>
            </a>

            <!-- Penyakit -->
            <a href="{{ route('diseases.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 {{ Request::is('diseases*') ? 'bg-indigo-50 text-indigo-700 font-medium border-l-4 border-indigo-700' : '' }}">
                <i class="fas fa-virus w-5 h-5 text-gray-400"></i>
                <span class="ml-4">Penyakit</span>
            </a>

            <!-- SPK -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200">
                    <i class="fas fa-cogs w-5 h-5 text-gray-400"></i>
                    <span class="ml-4 flex-1 text-left">SPK</span>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>

                <div x-show="open" x-collapse class="ml-8 pl-2 mt-1 space-y-1 border-l-2 border-gray-100">
                    <a href="{{ route('spk.gejala-tambahan.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus-circle w-4 h-4 mr-2"></i>
                        Gejala Tambahan
                    </a>
                    <a href="{{ route('spk.kriteria-ahp.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-balance-scale w-4 h-4 mr-2"></i>
                        Kriteria AHP
                    </a>
                    <a href="{{ route('spk.pengaturan-fuzzy.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-sliders-h w-4 h-4 mr-2"></i>
                        Pengaturan Fuzzy
                    </a>
                    <a href="{{ route('spk.proses-spk.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-calculator w-4 h-4 mr-2"></i>
                        Proses SPK
                    </a>
                    <a href="{{ route('spk.hasil-rekomendasi.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-list-ol w-4 h-4 mr-2"></i>
                        Hasil Rekomendasi
                    </a>
                    <a href="{{ route('spk.laporan-spk.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-chart-bar w-4 h-4 mr-2"></i>
                        Laporan SPK
                    </a>
                    <!-- New Submenus -->
                    <a href="{{ route('spk.penyakit.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-notes-medical w-4 h-4 mr-2"></i>
                        Penyakit
                    </a>
                    <a href="{{ route('spk.obat.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-capsules w-4 h-4 mr-2"></i>
                        Obat
                    </a>
                    <a href="{{ route('spk.aturan-fuzzy.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-project-diagram w-4 h-4 mr-2"></i>
                        Aturan Fuzzy
                    </a>
                    <a href="{{ route('spk.data-pasien.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-user-injured w-4 h-4 mr-2"></i>
                        Data Pasien
                    </a>
                    <a href="{{ route('spk.riwayat-konsultasi.index') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-history w-4 h-4 mr-2"></i>
                        Riwayat Konsultasi / Diagnosa
                    </a>
                </div>
            </div>

            <!-- Laporan Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200">
                    <i class="fas fa-file-alt w-5 h-5 text-gray-400"></i>
                    <span class="ml-4 flex-1 text-left">Laporan</span>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>

                <div x-show="open" x-collapse class="ml-8 pl-2 mt-1 space-y-1 border-l-2 border-gray-100">
                    <a href="{{ route('reports.patients') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-user w-4 h-4 mr-2"></i>
                        Pasien
                    </a>
                    <a href="{{ route('reports.prescriptions') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-prescription-bottle-alt w-4 h-4 mr-2"></i>
                        Resep
                    </a>
                    <a href="{{ route('reports.medicines') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-pills w-4 h-4 mr-2"></i>
                        Obat
                    </a>
                    <a href="{{ route('reports.diseases') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-virus w-4 h-4 mr-2"></i>
                        Penyakit
                    </a>
                    <a href="{{ route('reports.doctors') }}" class="flex items-center px-3 py-2 text-gray-500 hover:text-indigo-700 text-sm rounded-lg transition-colors duration-200">
                        <i class="fas fa-user-md w-4 h-4 mr-2"></i>
                        Dokter
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="md:ml-64 min-h-screen">
        <!-- Desktop Top Navigation -->
        <div class="hidden md:flex items-center justify-between h-16 px-8 bg-white shadow-sm">
            <div class="flex-1 max-w-3xl">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text"
                           class="w-full pl-10 pr-4 py-2 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all duration-300"
                           placeholder="Cari...">
                </div>
            </div>

            <div class="flex items-center space-x-6">
                <button class="relative text-gray-500 hover:text-indigo-600 p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 group">
                        <img class="w-9 h-9 rounded-full ring-2 ring-indigo-200 group-hover:ring-indigo-400 transition-all duration-300"
                             src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=indigo&color=fff"
                             alt="User avatar">
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                        </div>
                    </button>

                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 origin-top-right bg-white rounded-xl shadow-lg py-2 ring-1 ring-black ring-opacity-5 transition-all duration-300 opacity-0 scale-95"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50">Profil</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50">Pengaturan</a>
                        <hr class="my-2 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>

        <!-- Page Content -->
        <main class="p-6">
            <!-- Notifications -->
            @if(session('success'))
            <div class="mb-6 p-4 flex items-center bg-green-50 border border-green-200 rounded-xl">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 flex items-center bg-red-50 border border-red-200 rounded-xl">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Backdrop Mobile -->
    <div id="mobile-backdrop" class="fixed inset-0 bg-black/50 z-40 md:hidden" style="display: none;"></div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('mobile-backdrop');

        function toggleMenu() {
            const isOpen = sidebar.classList.toggle('-translate-x-full');
            backdrop.style.display = isOpen ? 'none' : 'block';
        }

        mobileMenuButton.addEventListener('click', toggleMenu);
        backdrop.addEventListener('click', toggleMenu);
    </script>
    @stack('scripts')
</body>
</html>
