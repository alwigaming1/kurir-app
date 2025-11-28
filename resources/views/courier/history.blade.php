<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Order</title>
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
        <div class="bg-white p-4 shadow-sm sticky top-0 z-10 text-center border-b">
            <h1 class="font-bold text-lg text-gray-800">Riwayat Pesanan</h1>
        </div>

        <div class="p-4 space-y-3">
            @if($histories->isEmpty())
                <div class="text-center py-20 text-gray-400">
                    <i class="fas fa-history text-3xl mb-3 text-gray-300"></i>
                    <p>Belum ada riwayat pesanan.</p>
                </div>
            @else
                @foreach($histories as $history)
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex justify-between items-center">
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $history->customer_name }}</p>
                        <p class="text-[10px] text-gray-400">{{ $history->updated_at->format('d M, H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-1 truncate w-40 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-red-400"></i> {{ $history->dropoff_location }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600 text-sm">+ Rp {{ number_format($history->ongkir) }}</p>
                        <span class="bg-green-100 text-green-700 text-[9px] px-2 py-0.5 rounded font-bold">SELESAI</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        @include('courier.menu')
    </div>
</body>
</html>