<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem PRB Puskesmas Purwanegara 1</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-background {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .input-focus-effect {
            transition: all 0.3s ease;
        }
        .input-focus-effect:focus-within {
            transform: translateY(-2px);
        }
        .loading-dots:after {
            content: '.';
            animation: dots 1.5s steps(5, end) infinite;
        }
        @keyframes dots {
            0%, 20% { content: '.'; }
            40% { content: '..'; }
            60% { content: '...'; }
            80% { content: ''; }
            100% { content: '.'; }
        }
        .typing-effect {
            border-right: 2px solid #3b82f6;
            animation: typing 1s steps(40) infinite;
        }
        @keyframes typing {
            from { border-color: #3b82f6; }
            to { border-color: transparent; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-xl flex items-center space-x-4">
            <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-600 border-t-transparent"></div>
            <span class="text-lg font-medium text-gray-700">Memuat<span class="loading-dots"></span></span>
        </div>
    </div>

    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left Side - Logo & Title -->
        <div class="hidden md:flex md:w-1/2 gradient-background p-8 flex-col items-center justify-center relative overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full transform translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full transform -translate-x-1/2 translate-y-1/2"></div>

            <!-- Logo & Title Container -->
            <div class="relative z-10 text-center">
                <img src="{{ asset('images/banjar.png') }}" alt="Logo Banjarnegara" class="h-48 mx-auto mb-8 hover:scale-105 transition-transform duration-300">
                <h1 class="text-3xl font-bold text-white mb-4 typing-effect">Puskesmas Purwanegara 1</h1>
                <p class="text-xl text-white/90 mb-8">Kabupaten Banjarnegara</p>
                <h2 class="text-2xl font-bold text-white mb-4">Sistem Program Rujuk Balik</h2>
                <p class="text-lg text-white/80 max-w-md mx-auto">
                    Sistem informasi terintegrasi untuk pengelolaan Program Rujuk Balik bagi petugas Puskesmas Purwanegara 1
                </p>

                <!-- Feature Icons -->
                <div class="mt-8 flex justify-center space-x-6">
                    <div class="text-center">
                        <div class="bg-white/10 p-4 rounded-lg mb-2 hover:bg-white/20 transition-colors">
                            <i class="fas fa-user-md text-2xl text-white"></i>
                        </div>
                        <span class="text-sm text-white/80">Manajemen PRB</span>
                    </div>
                    <div class="text-center">
                        <div class="bg-white/10 p-4 rounded-lg mb-2 hover:bg-white/20 transition-colors">
                            <i class="fas fa-pills text-2xl text-white"></i>
                        </div>
                        <span class="text-sm text-white/80">Kelola Obat</span>
                    </div>
                    <div class="text-center">
                        <div class="bg-white/10 p-4 rounded-lg mb-2 hover:bg-white/20 transition-colors">
                            <i class="fas fa-chart-line text-2xl text-white"></i>
                        </div>
                        <span class="text-sm text-white/80">Monitoring</span>
                    </div>
                </div>
            </div>

            <!-- Footer Address -->
            <div class="absolute bottom-8 left-0 right-0 text-white/70 text-sm text-center">
                <div class="flex items-center justify-center space-x-2 mb-2">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Jl. Jenderal Sudirman No. 123, Purwanegara, Banjarnegara</p>
                </div>
                <p>Jawa Tengah</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="md:hidden flex flex-col items-center mb-8">
                    <img src="{{ asset('images/banjar.png') }}" alt="Logo Banjarnegara" class="h-24 mb-4">
                    <div class="text-center">
                        <h1 class="text-xl font-bold text-gray-900">Puskesmas Purwanegara 1</h1>
                        <p class="text-sm text-gray-600">Kabupaten Banjarnegara</p>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                    <div class="text-center mb-8">
                        <div class="inline-block p-3 rounded-full bg-blue-100 mb-4">
                            <i class="fas fa-user-md text-2xl text-blue-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Login Petugas</h2>
                        <p class="mt-2 text-sm text-gray-600">Masuk ke Sistem Program Rujuk Balik</p>
                    </div>

                    <form id="loginForm" class="space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="input-focus-effect">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-blue-500"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="nama@puskesmas.com"
                                    required
                                    autocomplete="email">
                                <div class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-check text-green-500"></i>
                                </div>
                            </div>
                            @error('email')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="input-focus-effect">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-blue-500"></i>
                                </div>
                                <input type="password" name="password" id="password"
                                    class="block w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="••••••••"
                                    required>
                                <button type="button"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none"
                                    onclick="togglePassword()">
                                    <i class="fas fa-eye text-gray-400 hover:text-blue-500"></i>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Ingat Saya
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                Lupa Password?
                            </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" id="loginButton"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span>Masuk ke Sistem</span>
                        </button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600 text-sm">
                        © {{ date('Y') }} Puskesmas Purwanegara 1
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        Sistem Program Rujuk Balik
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.fa-eye');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }

        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loadingOverlay = document.getElementById('loading-overlay');
            const loginButton = document.getElementById('loginButton');

            // Show loading state
            loadingOverlay.classList.remove('hidden');
            loginButton.disabled = true;
            loginButton.innerHTML = `
                <div class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent mr-2"></div>
                <span>Memproses...</span>
            `;
        });

        // Email validation
        const emailInput = document.getElementById('email');
        const checkIcon = emailInput.parentElement.querySelector('.fa-check').parentElement;

        emailInput.addEventListener('input', function() {
            const isValid = this.checkValidity() && this.value.includes('@');
            checkIcon.classList.toggle('hidden', !isValid);
        });
    </script>
</body>
</html>
