<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistem PRB - Puskesmas Purwanegara 1</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('images/banjar.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html, body {
                height: 100%;
                margin: 0;
                scroll-behavior: smooth;
            }
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                background-color: #f8fafc;
            }
            .hero-pattern {
                background-color: #ffffff;
                background-image: linear-gradient(120deg, #e0f2fe 0%, #ffffff 100%);
            }
            main {
                flex: 1 0 auto;
            }
            footer {
                flex-shrink: 0;
            }
            .nav-link {
                position: relative;
                transition: color 0.3s ease;
            }
            .nav-link::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: -2px;
                left: 0;
                background-color: #2563eb;
                transition: width 0.3s ease;
            }
            .nav-link:hover::after {
                width: 100%;
            }
            .feature-card {
                background-color: #ffffff;
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                border-color: #2563eb;
            }
            .stat-card {
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            }
            .flow-step {
                background-color: #ffffff;
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            .flow-step:hover {
                transform: translateX(5px);
                border-color: #2563eb;
            }
            .faq-item {
                background-color: #ffffff;
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            .faq-item:hover {
                border-color: #2563eb;
            }
            .section-alt {
                background-color: #ffffff;
            }
            .section-light {
                background-color: #f8fafc;
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }
            .section-pattern {
                background-color: #ffffff;
                background-image:
                    linear-gradient(45deg, #f0f9ff 25%, transparent 25%),
                    linear-gradient(-45deg, #f0f9ff 25%, transparent 25%),
                    linear-gradient(45deg, transparent 75%, #f0f9ff 75%),
                    linear-gradient(-45deg, transparent 75%, #f0f9ff 75%);
                background-size: 20px 20px;
                background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
            }
            @media (max-width: 768px) {
                .hero-pattern {
                    background-size: 200px 200px;
                }
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50">
        <!-- Skip to main content -->
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:p-4 focus:bg-white focus:text-blue-600">
            Skip to main content
        </a>

        <!-- Header/Navigation -->
        <header class="bg-white shadow-sm fixed w-full top-0 z-50">
            <nav class="container mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/banjar.png') }}"
                             alt="Logo Puskesmas Purwanegara 1"
                             class="h-12 w-auto mr-2">
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 leading-tight">Puskesmas Purwanegara 1</h1>
                            <p class="text-sm text-gray-600">Kabupaten Banjarnegara</p>
                            <p class="text-xs text-blue-600">Sistem PRB</p>
                        </div>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#tentang" class="nav-link text-gray-600 hover:text-blue-600">Tentang</a>
                        <a href="#layanan" class="nav-link text-gray-600 hover:text-blue-600">Layanan</a>
                        <a href="#alur" class="nav-link text-gray-600 hover:text-blue-600">Alur</a>
                        <a href="#faq" class="nav-link text-gray-600 hover:text-blue-600">FAQ</a>
                        <a href="#kontak" class="nav-link text-gray-600 hover:text-blue-600">Kontak</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                                    <i class="fas fa-home mr-2"></i>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Masuk Sistem
                                </a>
                            @endauth
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-600 hover:text-blue-600 focus:outline-none" id="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="pt-4 pb-3 space-y-3">
                        <a href="#tentang" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Tentang</a>
                        <a href="#layanan" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Layanan</a>
                        <a href="#alur" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Alur</a>
                        <a href="#faq" class="block px-3 py-2 text-gray-600 hover:text-blue-600">FAQ</a>
                        <a href="#kontak" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Kontak</a>
                        @if (Route::has('login'))
                            @guest
                                <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-600 hover:text-blue-600">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Masuk Sistem
                                </a>
                            @endguest
                        @endif
                    </div>
                </div>
            </nav>
        </header>

        <main id="main-content">
            <!-- Hero Section -->
            <section class="pt-24 pb-16 hero-pattern">
                <div class="container mx-auto px-6">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                        <div class="lg:w-1/2">
                            <div class="bg-blue-600/10 text-blue-600 text-sm font-semibold px-4 py-2 rounded-full inline-block mb-6">
                                <i class="fas fa-star-of-life mr-2"></i>
                                Sistem PRB
                            </div>
                            <h2 class="text-4xl font-bold text-gray-800 mb-6 leading-tight">
                                Sistem <span class="text-blue-600">Program Rujuk Balik</span>
                            </h2>
                            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                                Sistem pendukung keputusan untuk pengelolaan Program Rujuk Balik Puskesmas Purwanegara 1
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                @guest
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Login Petugas
                                    </a>
                                    <a href="#alur" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-blue-600 border-2 border-blue-600 rounded-lg hover:bg-blue-50 transition-all">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Pelajari Lebih Lanjut
                                    </a>
                                @endguest
                            </div>
                        </div>
                        <div class="lg:w-1/2 flex flex-col items-center justify-center mt-8 lg:mt-0">
                            <div class="mb-6">
                                <i class="fas fa-stethoscope text-blue-500" style="font-size: 100px;"></i>
                            </div>
                            <div class="p-4 bg-blue-50 rounded-xl shadow text-blue-900 text-center max-w-xs">
                                <h3 class="font-bold mb-2">Apa itu PRB?</h3>
                                <p class="text-sm">Program Rujuk Balik (PRB) adalah layanan untuk pasien penyakit kronis agar dapat mengambil obat secara rutin di fasilitas kesehatan tingkat pertama.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-16 section-light">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Fitur Utama</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Sistem PRB menyediakan berbagai fitur untuk memudahkan pengelolaan Program Rujuk Balik</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-user-injured text-blue-600 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Manajemen Pasien</h3>
                            <p class="text-gray-600">Kelola data pasien rujuk balik dengan mudah dan terstruktur</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-pills text-blue-600 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Rekomendasi Obat</h3>
                            <p class="text-gray-600">Sistem pendukung keputusan untuk rekomendasi obat menggunakan Fuzzy AHP</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-chart-line text-blue-600 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Laporan & Statistik</h3>
                            <p class="text-gray-600">Pantau perkembangan program melalui laporan dan statistik yang informatif</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Service Flow Section -->
            <section id="alur" class="py-16 section-alt">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Alur Layanan</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Proses layanan Program Rujuk Balik yang terstruktur dan efisien</p>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-stretch gap-8">
                        <div class="flex-1 flex flex-col items-center text-center relative">
                            <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex flex-col items-center justify-center mb-2">
                                <i class="fas fa-id-card text-2xl mb-1"></i>
                                <span class="font-bold">1</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">Pendaftaran Pasien</h3>
                            <p class="text-sm text-gray-600">Pasien mendaftar dengan membawa surat rujuk balik dari fasilitas kesehatan</p>
                            <div class="hidden md:block absolute top-8 right-0 w-full h-1 border-t-2 border-blue-200 z-0" style="left: 100%; width: 40px;"></div>
                        </div>
                        <div class="flex-1 flex flex-col items-center text-center relative">
                            <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex flex-col items-center justify-center mb-2">
                                <i class="fas fa-user-md text-2xl mb-1"></i>
                                <span class="font-bold">2</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">Pemeriksaan Dokter</h3>
                            <p class="text-sm text-gray-600">Dokter melakukan pemeriksaan dan menentukan kebutuhan obat</p>
                            <div class="hidden md:block absolute top-8 right-0 w-full h-1 border-t-2 border-blue-200 z-0" style="left: 100%; width: 40px;"></div>
                        </div>
                        <div class="flex-1 flex flex-col items-center text-center relative">
                            <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex flex-col items-center justify-center mb-2">
                                <i class="fas fa-pills text-2xl mb-1"></i>
                                <span class="font-bold">3</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">Rekomendasi Obat</h3>
                            <p class="text-sm text-gray-600">Sistem memberikan rekomendasi obat berdasarkan kriteria yang ditentukan</p>
                            <div class="hidden md:block absolute top-8 right-0 w-full h-1 border-t-2 border-blue-200 z-0" style="left: 100%; width: 40px;"></div>
                        </div>
                        <div class="flex-1 flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex flex-col items-center justify-center mb-2">
                                <i class="fas fa-hand-holding-medical text-2xl mb-1"></i>
                                <span class="font-bold">4</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-1">Pemberian Obat</h3>
                            <p class="text-sm text-gray-600">Petugas memberikan obat sesuai rekomendasi sistem</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Statistics Section -->
            <section class="py-16 section-light">
                <div class="container mx-auto px-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="stat-card p-6 rounded-xl text-white text-center">
                            <div class="text-3xl font-bold mb-2">1000+</div>
                            <div class="text-sm">Pasien Terlayani</div>
                        </div>
                        <div class="stat-card p-6 rounded-xl text-white text-center">
                            <div class="text-3xl font-bold mb-2">98%</div>
                            <div class="text-sm">Tingkat Kepuasan</div>
                        </div>
                        <div class="stat-card p-6 rounded-xl text-white text-center">
                            <div class="text-3xl font-bold mb-2">24/7</div>
                            <div class="text-sm">Layanan Sistem</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-16 section-alt">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Pertanyaan Umum</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Informasi penting seputar Program Rujuk Balik</p>
                    </div>
                    <div class="max-w-3xl mx-auto space-y-4">
                        <div x-data="{ open: false }" class="faq-item bg-white rounded-xl shadow-sm p-6">
                            <button @click="open = !open" class="flex items-center w-full text-left focus:outline-none">
                                <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                                <span class="font-semibold">Apa itu Program Rujuk Balik?</span>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-auto"></i>
                            </button>
                            <div x-show="open" class="mt-2 text-gray-600">
                                Program Rujuk Balik adalah program yang memungkinkan pasien untuk mendapatkan obat di fasilitas kesehatan tingkat pertama setelah dirujuk dari fasilitas kesehatan rujukan.
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="faq-item bg-white rounded-xl shadow-sm p-6">
                            <button @click="open = !open" class="flex items-center w-full text-left focus:outline-none">
                                <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                                <span class="font-semibold">Siapa saja yang bisa mengikuti PRB?</span>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-auto"></i>
                            </button>
                            <div x-show="open" class="mt-2 text-gray-600">
                                Pasien dengan kartu BPJS Kesehatan dan surat rujuk balik dari fasilitas kesehatan rujukan.
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="faq-item bg-white rounded-xl shadow-sm p-6">
                            <button @click="open = !open" class="flex items-center w-full text-left focus:outline-none">
                                <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                                <span class="font-semibold">Bagaimana cara mendaftar PRB di Puskesmas?</span>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-auto"></i>
                            </button>
                            <div x-show="open" class="mt-2 text-gray-600">
                                Datang ke Puskesmas dengan membawa kartu BPJS dan surat rujuk balik, lalu lakukan pendaftaran di loket PRB.
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="faq-item bg-white rounded-xl shadow-sm p-6">
                            <button @click="open = !open" class="flex items-center w-full text-left focus:outline-none">
                                <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                                <span class="font-semibold">Apa yang harus dibawa saat mengambil obat PRB?</span>
                                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-auto"></i>
                            </button>
                            <div x-show="open" class="mt-2 text-gray-600">
                                Bawa kartu BPJS, surat rujuk balik, dan identitas diri saat mengambil obat PRB di Puskesmas.
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="kontak" class="py-16 section-light">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi kami
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Alamat</h3>
                                    <p class="text-gray-600">Jl. Raya Purwanegara No. 1, Purwanegara, Banjarnegara, Jawa Tengah</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-phone-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Telepon</h3>
                                    <p class="text-gray-600">(0281) 123456</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-yellow-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Email</h3>
                                    <p class="text-gray-600">info@puskesmaspurwanegara1.go.id</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-xl">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.333783189743!2d109.5699456758852!3d-7.4282655925823935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aa90f47c250d1%3A0x15276cb7b24ffe90!2sPuskesmas%20Purwanegara%201!5e0!3m2!1sid!2ssg!4v1748354692078!5m2!1sid!2ssg"
                                width="100%"
                                height="350"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-map-marker-alt w-6"></i>
                                <span>Jl. Raya Purwanegara No. 1, Banjarnegara</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone w-6"></i>
                                <span>(0286) 123456</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope w-6"></i>
                                <span>info@puskesmas-purwanegara.go.id</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                        <ul class="space-y-2">
                            <li><a href="#alur" class="hover:text-blue-400 transition-colors">Alur Layanan</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="hover:text-blue-400 transition-colors">
                                <i class="fab fa-facebook text-2xl"></i>
                            </a>
                            <a href="#" class="hover:text-blue-400 transition-colors">
                                <i class="fab fa-instagram text-2xl"></i>
                            </a>
                            <a href="#" class="hover:text-blue-400 transition-colors">
                                <i class="fab fa-twitter text-2xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p>&copy; {{ date('Y') }} Puskesmas Purwanegara 1. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Mobile Menu Script -->
        <script>
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        </script>

        <!-- Tambahkan Alpine.js jika belum ada -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html>
