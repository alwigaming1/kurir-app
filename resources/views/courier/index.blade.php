<!DOCTYPE html>
<html lang="id">
<head>
    <title>Home Driver</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .mobile-container { max-width: 480px; margin: 0 auto; background: #f8fafc; min-height: 100vh; position: relative; }
    </style>
</head>
<body>
    <div class="mobile-container pb-28">
        
        <div class="bg-blue-600 pb-12 rounded-b-[2.5rem] px-6 pt-8 text-white relative overflow-hidden shadow-lg">
             <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
             <div class="flex justify-between items-center mb-6 relative z-10">
                <div>
                    <p class="text-blue-200 text-[10px] font-bold uppercase tracking-wider">Driver Mode</p>
                    <h1 class="font-bold text-xl">{{ Str::limit(Auth::user()->name, 15) }}</h1>
                </div>
                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-full flex items-center justify-center border border-white/20 shadow-sm">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 text-gray-800 shadow-xl flex justify-between items-center relative z-10 border border-blue-50">
                <div>
                    <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Pendapatan Hari Ini</p>
                    <h2 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($todayEarnings ?? 0) }}</h2>
                </div>
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl shadow-sm">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>

        <div class="px-5 mt-6">
            <a href="{{ route('kurir.active') }}" class="bg-white border border-gray-100 rounded-2xl p-4 flex justify-between items-center mb-8 hover:bg-gray-50 transition shadow-sm group relative overflow-hidden">
                <div class="absolute left-0 top-0 h-full w-1 bg-orange-500"></div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center shadow-sm">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Lihat Tugas Aktif</h3>
                        <p class="text-[10px] text-gray-500">Cek pesanan yang sedang diproses</p>
                    </div>
                </div>
                <div class="w-8 h-8 bg-gray-50 rounded-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <div>
                <div class="flex justify-between items-end mb-4 px-1">
                    <h2 class="font-bold text-gray-800 text-lg">Orderan Masuk</h2>
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full border border-blue-100">{{ $availableOrders->count() }} Baru</span>
                </div>

                @if($availableOrders->isEmpty())
                    <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-mug-hot text-gray-300 text-3xl"></i>
                        </div>
                        <p class="text-gray-800 font-bold">Lagi sepi nih...</p>
                        <p class="text-xs text-gray-400 mt-1">Belum ada orderan baru masuk</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($availableOrders as $order)
                        <div class="bg-white rounded-[1.5rem] p-5 shadow-[0_2px_15px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden transition hover:-translate-y-1 duration-300">
                            
                            <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0 border border-blue-100">
                                        {{ substr($order->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-[15px] leading-tight">{{ $order->customer_name }}</h3>
                                        
                                        <div class="flex items-center gap-2 mt-1.5">
                                            @if($order->distance)
                                            <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-100 text-indigo-600 text-[10px] font-bold">
                                                <i class="fas fa-route"></i> {{ $order->distance }} km
                                            </div>
                                            @endif
                                            <span class="text-[10px] text-gray-400 flex items-center gap-1">
                                                <i class="far fa-clock"></i> {{ $order->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block font-extrabold text-lg text-green-600">Rp {{ number_format($order->ongkir) }}</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-3 mb-4 flex items-start gap-3 border border-gray-100">
                                <div class="mt-0.5 text-gray-400"><i class="fas fa-box-open"></i></div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Isi Paket</p>
                                    <p class="text-sm font-bold text-gray-800 leading-snug">{{ $order->item_name }}</p>
                                </div>
                            </div>

                            <div class="relative pl-3 mb-5">
                                <div class="absolute left-[19px] top-3 bottom-4 w-[2px] border-l-2 border-dashed border-gray-200"></div>
                                <div class="flex gap-4 mb-4 relative z-10">
                                    <div class="mt-0.5">
                                        <div class="w-3.5 h-3.5 rounded-full border-[3px] border-blue-500 bg-white shadow-sm"></div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Jemput</p>
                                        <p class="text-sm font-medium text-gray-700 leading-snug">{{ $order->pickup_location }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 relative z-10">
                                    <div class="mt-0.5">
                                        <div class="w-3.5 h-3.5 rounded-full bg-red-500 border-2 border-white shadow-md"></div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Antar</p>
                                        <p class="text-sm font-medium text-gray-700 leading-snug">{{ $order->dropoff_location }}</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('kurir.take', $order->id) }}" method="POST">
                                @csrf
                                <button class="w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold text-sm shadow-lg shadow-slate-200 hover:bg-slate-800 active:scale-95 transition flex items-center justify-center gap-2 group">
                                    <span>AMBIL ORDER</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @include('courier.menu')
    </div>
</body>
</html>