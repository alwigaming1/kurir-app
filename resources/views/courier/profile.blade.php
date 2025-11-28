<!DOCTYPE html>
<html lang="id">
<head>
    <title>Akun Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
        .mobile-container { max-width: 480px; margin: 0 auto; background: white; min-height: 100vh; position: relative; }
    </style>
</head>
<body>
    <div class="mobile-container pb-24">
        
        <div class="bg-blue-600 text-white p-8 pt-12 text-center rounded-b-[2.5rem] mb-6 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-white opacity-5"></div>
            
            <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-full mx-auto flex items-center justify-center text-4xl mb-4 border-4 border-white/30 shadow-lg relative z-10">
                <i class="fas fa-user"></i>
            </div>
            <h2 class="font-bold text-xl relative z-10">{{ Auth::user()->name }}</h2>
            <p class="text-blue-200 text-sm relative z-10">{{ Auth::user()->email }}</p>
        </div>

        <div class="px-5">
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm grid grid-cols-2 gap-4 text-center mb-6">
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-1">Total Order</p>
                    <p class="font-bold text-2xl text-gray-800">{{ $completedCount }}</p>
                </div>
                <div class="border-l border-gray-100">
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-1">Total Pendapatan</p>
                    <p class="font-bold text-2xl text-green-600">Rp {{ number_format($totalEarnings) }}</p>
                </div>
            </div>

            <form action="/admin/logout" method="POST">
                @csrf
                <button class="w-full bg-red-50 text-red-600 p-4 rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-red-100 transition shadow-sm border border-red-100">
                    <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
                </button>
            </form>
            
            <p class="text-center text-gray-300 text-xs mt-8">Versi Aplikasi 1.0.0</p>
        </div>

        @include('courier.menu')
    </div>
</body>
</html>