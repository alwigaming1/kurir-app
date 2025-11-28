<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KurirKilat - Jasa Titip Pasar & Antar Paket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-bg {
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1616401784845-180882ba9ba8?q=80&w=1000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-blue-600 text-white flex items-center justify-center rounded-lg font-bold text-xl">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-blue-900">KurirKilat</span>
                </div>

                <div class="hidden md:flex items-center space-x-8 font-medium">
                    <a href="#" class="text-blue-600 hover:text-blue-800">Beranda</a>
                    <a href="#layanan" class="text-gray-600 hover:text-blue-600">Layanan</a>
                    <a href="#cek-resi" class="text-gray-600 hover:text-blue-600">Cek Resi</a>
                    <a href="/admin/login" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">Login Admin/Kurir</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="hero-bg h-[500px] flex items-center justify-center text-center px-4 relative">
        <div class="max-w-3xl text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Belanja Pasar & Kirim Paket Jadi Mudah</h1>
            <p class="text-lg md:text-xl mb-8 text-gray-200">Solusi logistik cepat untuk kebutuhan harian Anda. Dari pasar tradisional langsung ke depan pintu rumah.</p>
            
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20mau%20pesan%20jasa%20kurir..." target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-full font-bold text-lg transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp"></i> Pesan Sekarang
                </a>
                <a href="#cek-resi" class="bg-white text-blue-900 hover:bg-gray-100 px-8 py-3 rounded-full font-bold text-lg transition shadow-lg">
                    Lacak Paket
                </a>
            </div>
        </div>
    </div>

    <section id="cek-resi" class="py-12 -mt-16 relative z-10 px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 border-t-4 border-blue-600">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">📦 Lacak Kiriman Anda</h2>
            
            <form action="{{ route('cek.resi') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <input type="number" name="resi" placeholder="Masukkan Nomor Order (Contoh: 1)" class="flex-1 px-6 py-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg bg-gray-50" required>
                <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i> Cek Resi
                </button>
            </form>

            @if(session('found'))
                <div class="mt-8 bg-blue-50 p-6 rounded-xl border border-blue-100 animate-fade-in-down">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Order: #{{ session('resi') }}</p>
                            <h3 class="font-bold text-xl">{{ session('penerima') }}</h3>
                        </div>
                        <div class="ml-auto text-right">
                            <span class="px-3 py-1 rounded-full text-sm font-bold 
                                {{ session('status') == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ session('status') == 'completed' ? 'SELESAI' : strtoupper(session('status')) }}
                            </span>
                        </div>
                    </div>
                    <hr class="border-blue-200 mb-4">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Update Terakhir: {{ session('updated') }}</span>
                        <span class="font-bold">{{ session('lokasi') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mt-6 bg-red-100 text-red-700 p-4 rounded-lg text-center font-bold">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </section>

    <section id="layanan" class="py-16 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Layanan Unggulan</h2>
            <div class="grid md:grid-cols-3 gap-8">
                
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition text-center border border-gray-100">
                    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="fas fa-carrot"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Jasa Belanja Pasar</h3>
                    <p class="text-gray-500 mb-6">Anda kirim daftar belanja, kami yang pergi ke pasar. Sayur segar langsung ke dapur.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition text-center border border-gray-100">
                    <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Kurir Instan</h3>
                    <p class="text-gray-500 mb-6">Kirim dokumen, paket, atau makanan dalam kota. Cepat, aman, dan terpercaya.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition text-center border border-gray-100">
                    <div class="w-20 h-20 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Titip Beli Makanan</h3>
                    <p class="text-gray-500 mb-6">Lagi mager? Biar kami yang antri beli makanan favorit Anda di resto mana saja.</p>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-10 text-center">
        <p class="font-bold text-xl mb-2">KurirKilat</p>
        <p class="text-gray-400 text-sm">© 2025 Solusi Logistik Hemat & Cepat.</p>
    </footer>

</body>
</html>