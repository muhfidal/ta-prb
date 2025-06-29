<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem PRB Puskesmas Purwanegara 1 - Coming Soon</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Main Content -->
    <main class="hero-gradient min-h-screen flex items-center justify-center p-4">
        <div class="max-w-4xl w-full">
            <!-- Logo dan Badge -->
            <div class="text-center mb-12">
                <div class="inline-block p-4 bg-white/20 rounded-full mb-6">
                    <i class="fas fa-hospital text-4xl md:text-5xl text-white"></i>
                </div>
                <div class="inline-block glass-effect rounded-full px-6 py-2 mb-6">
                    <span class="text-white font-semibold flex items-center gap-2">
                        <i class="fas fa-clock pulse"></i>
                        Coming Soon
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="glass-effect rounded-2xl p-8 md:p-12 text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-6">Sistem PRB Puskesmas Purwanegara 1</h1>
                <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Sistem Pendukung Keputusan Program Rujuk Balik berbasis Fuzzy AHP yang akan membantu tenaga medis dalam memberikan rekomendasi terapi yang tepat dan efisien.
                </p>

                <!-- Features Preview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="glass-effect rounded-xl p-6">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-brain text-white text-xl"></i>
                        </div>
                        <h3 class="text-white font-semibold mb-2">Fuzzy AHP</h3>
                        <p class="text-blue-100 text-sm">Metode pengambilan keputusan yang akurat</p>
                    </div>
                    <div class="glass-effect rounded-xl p-6">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <h3 class="text-white font-semibold mb-2">Analisis Real-time</h3>
                        <p class="text-blue-100 text-sm">Evaluasi data secara cepat dan tepat</p>
                    </div>
                    <div class="glass-effect rounded-xl p-6">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-user-md text-white text-xl"></i>
                        </div>
                        <h3 class="text-white font-semibold mb-2">Dukungan Medis</h3>
                        <p class="text-blue-100 text-sm">Bantuan pengambilan keputusan klinis</p>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                        Daftar untuk Update
                    </a>
                    <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-colors">
                        Hubungi Kami
                    </a>
                </div>

                <!-- Social Links -->
                <div class="flex justify-center gap-6">
                    <a href="#" class="text-white hover:text-blue-200 transition-colors">
                        <i class="fab fa-whatsapp text-2xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-200 transition-colors">
                        <i class="fab fa-telegram text-2xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-200 transition-colors">
                        <i class="fas fa-envelope text-2xl"></i>
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-white/60 text-sm">&copy; 2025 Puskesmas Purwanegara 1. All rights reserved.</p>
            </div>
        </div>
    </main>
</body>
</html>
