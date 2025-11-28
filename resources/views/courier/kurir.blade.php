<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
        .mobile-container { max-width: 480px; margin: 0 auto; background: white; min-height: 100vh; position: relative; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="mobile-container pb-24">
        <div class="bg-white p-4 shadow-sm sticky top-0 z-10 text-center border-b">
            <h1 class="font-bold text-lg">Riwayat Pesanan</h1>
        </div>

        <div class="p-4 space-y-3">
            @if($histories->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <p>Belum ada riwayat pesanan.</p>
                </div>
            @else
                @foreach($histories as $history)
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex justify-between items-center">
                    <div>
                        <p class="font-bold text-gray-800">{{ $history->customer_name }}</p>
                        <p class="text-xs text-gray-400">{{ $history->updated_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-1 truncate w-40">{{ $history->dropoff_location }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">+ Rp {{ number_format($history->ongkir) }}</p>
                        <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded font-bold">SELESAI</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-6 py-3 flex justify-between items-center z-50 max-w-[480px]">
            <a href="{{ route('kurir.index') }}" class="flex flex-col items-center text-gray-400 hover:text-blue-600">
                <i class="fas fa-home text-xl"></i>
                <span class="text-[10px] font-medium mt-1">Home</span>
            </a>
            <a href="{{ route('kurir.history') }}" class="flex flex-col items-center text-blue-600">
                <i class="fas fa-history text-xl"></i>
                <span class="text-[10px] font-bold mt-1">Riwayat</span>
            </a>
            <a href="{{ route('kurir.profile') }}" class="flex flex-col items-center text-gray-400 hover:text-blue-600">
                <i class="fas fa-user text-xl"></i>
                <span class="text-[10px] font-medium mt-1">Akun</span>
            </a>
        </div>
    </div>
</body>
</html>