<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tugas Aktif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .mobile-container { max-width: 480px; margin: 0 auto; background: #f8fafc; min-height: 100vh; position: relative; }
        
        /* Chat Styles */
        .chat-me { background: #dcf8c6; align-self: flex-end; border-radius: 10px 0 10px 10px; }
        .chat-guest { background: #fff; align-self: flex-start; border-radius: 0 10px 10px 10px; }
    </style>
</head>
<body>
    <div class="mobile-container pb-28">
        <div class="bg-blue-600 p-6 pt-8 pb-10 text-white rounded-b-[2rem] mb-6 shadow-md">
            <h1 class="font-bold text-xl">Tugas Saya</h1>
            <p class="text-blue-200 text-xs mt-1">Selesaikan pesanan untuk terima gaji</p>
        </div>

        <div class="px-5">
            @if(session('success'))
                <div class="bg-green-50 text-green-700 p-3 rounded-xl text-sm font-bold mb-6 flex items-center gap-2 border border-green-200 shadow-sm animate-pulse">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($myActiveOrders->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm mt-4">
                    <i class="fas fa-shipping-fast text-gray-200 text-5xl mb-4"></i>
                    <p class="text-gray-500 font-bold">Tidak ada tugas aktif.</p>
                    <a href="{{ route('kurir.index') }}" class="inline-block mt-6 bg-blue-600 text-white px-8 py-3 rounded-full text-sm font-bold shadow-lg shadow-blue-200 active:scale-95 transition">Cari Order</a>
                </div>
            @else
                @foreach($myActiveOrders as $order)
                <div class="bg-white border border-blue-100 rounded-[1.5rem] p-5 shadow-md mb-6 relative overflow-hidden transition hover:-translate-y-1 duration-300">
                    
                    <div class="absolute top-4 right-4 bg-white rounded-full shadow-sm border border-gray-100 p-1 flex items-center gap-1 z-10">
                        @if($order->distance)
                        <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold">
                            <i class="fas fa-location-arrow"></i> {{ $order->distance }} km
                        </div>
                        @endif
                        <div class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-bold flex items-center gap-1">
                            <i class="fas fa-spinner fa-spin"></i> PROSES
                        </div>
                    </div>
                    
                    <div class="mt-2 mb-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pelanggan</p>
                        <h3 class="font-bold text-2xl text-gray-800 leading-none mb-2">{{ $order->customer_name }}</h3>
                        <p class="text-blue-600 font-extrabold text-lg">Rp {{ number_format($order->ongkir) }}</p>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-5 flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">Barang / Pesanan</p>
                            <p class="text-base font-bold text-gray-800 leading-snug">{{ $order->item_name }}</p>
                            @if($order->notes)
                                <p class="text-xs text-gray-500 mt-1 italic">"{{ $order->notes }}"</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="space-y-5 mb-6 pl-2 relative border-l-2 border-gray-100 ml-2 py-2">
                        <div class="relative pl-5">
                            <div class="absolute -left-[7px] top-1.5 w-3.5 h-3.5 bg-white border-[3px] border-blue-500 rounded-full"></div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Lokasi Ambil</p>
                            <p class="text-sm font-medium text-gray-800 leading-snug">{{ $order->pickup_location }}</p>
                        </div>
                        <div class="relative pl-5">
                            <div class="absolute -left-[7px] top-1.5 w-3.5 h-3.5 bg-red-500 rounded-full border-2 border-white shadow"></div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Lokasi Antar</p>
                            <p class="text-sm font-medium text-gray-800 leading-snug">{{ $order->dropoff_location }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <button onclick="openChat({{ $order->id }}, '{{ $order->customer_name }}')" class="flex items-center justify-center gap-2 py-3 bg-green-500 text-white rounded-xl font-bold text-sm shadow-md hover:bg-green-600 transition active:scale-95">
                            <i class="fas fa-comments text-lg"></i> Chat
                        </button>
                        
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->dropoff_location) }}" target="_blank" class="flex items-center justify-center gap-2 py-3 bg-blue-50 text-blue-700 rounded-xl font-bold text-sm border border-blue-100 hover:bg-blue-100 transition">
                            <i class="fas fa-location-arrow text-lg"></i> Maps
                        </a>
                    </div>
                    
                    <form action="{{ route('kurir.complete', $order->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold shadow-lg shadow-slate-200 active:scale-95 transition flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Selesaikan Pesanan
                        </button>
                    </form>
                </div>
                @endforeach
            @endif
        </div>

        @include('courier.menu')
    </div>

    <div id="chatModal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeChat()"></div>
        <div class="absolute bottom-0 w-full max-w-[480px] left-0 right-0 mx-auto bg-[#efe7dd] rounded-t-[2rem] h-[85vh] flex flex-col shadow-2xl transition-transform transform translate-y-0">
            <div class="bg-[#008069] p-4 rounded-t-[2rem] text-white flex justify-between items-center shadow-md z-10">
                <div class="flex items-center gap-3">
                    <button onclick="closeChat()"><i class="fas fa-arrow-left"></i></button>
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center"><i class="fas fa-user"></i></div>
                    <div>
                        <h3 id="chatName" class="font-bold text-base truncate w-32">Pelanggan</h3>
                        <p class="text-[10px] text-white/80">Online</p>
                    </div>
                </div>
                <button onclick="closeChat()"><i class="fas fa-times"></i></button>
            </div>
            <div id="chatBox" class="flex-1 overflow-y-auto p-4 space-y-2 flex flex-col">
                <div class="bg-[#ffeb3b] text-yellow-900 text-[10px] text-center p-2 rounded-lg mx-auto w-fit shadow-sm">
                    <i class="fas fa-lock"></i> Pesan ini terenkripsi.
                </div>
            </div>
            <div class="p-3 bg-white flex gap-2 items-center">
                <input type="text" id="chatInput" placeholder="Ketik pesan..." class="flex-1 bg-gray-100 border-none rounded-full px-4 py-3 focus:ring-0">
                <button onclick="sendChat()" class="w-11 h-11 bg-[#008069] text-white rounded-full flex items-center justify-center shadow-md active:scale-90 transition">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentOrderId = null;
        let chatInterval = null;

        function openChat(id, name) {
            currentOrderId = id;
            document.getElementById('chatName').innerText = name;
            document.getElementById('chatModal').classList.remove('hidden');
            loadChats();
            chatInterval = setInterval(loadChats, 3000);
        }

        function closeChat() {
            document.getElementById('chatModal').classList.add('hidden');
            clearInterval(chatInterval);
        }

        function loadChats() {
            if(!currentOrderId) return;
            $.get(`/chat/get/${currentOrderId}`, function(chats) {
                let html = '<div class="bg-[#ffeb3b] text-yellow-900 text-[10px] text-center p-2 rounded-lg mx-auto w-fit shadow-sm mb-4"><i class="fas fa-lock"></i> Privasi terjaga.</div>';
                chats.forEach(chat => {
                    let time = new Date(chat.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    if(chat.sender === 'courier') {
                        html += `<div class="chat-me p-2 px-3 text-sm shadow-sm max-w-[80%] mb-1 relative text-gray-800">${chat.message}<span class="text-[9px] text-gray-500 block text-right mt-1">${time} <i class="fas fa-check-double text-blue-500"></i></span></div>`;
                    } else {
                        html += `<div class="chat-guest p-2 px-3 text-sm shadow-sm max-w-[80%] mb-1 relative text-gray-800">${chat.message}<span class="text-[9px] text-gray-400 block mt-1">${time}</span></div>`;
                    }
                });
                let box = document.getElementById('chatBox');
                box.innerHTML = html;
            });
        }

        function sendChat() {
            let msg = document.getElementById('chatInput').value;
            if(!msg || !currentOrderId) return;
            
            let chatBox = document.getElementById('chatBox');
            chatBox.innerHTML += `<div class="chat-me p-2 px-3 text-sm shadow-sm max-w-[80%] mb-1 bg-gray-200 opacity-50">${msg}</div>`;
            document.getElementById('chatInput').value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            $.ajax({
                url: `/chat/send/${currentOrderId}`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    message: msg
                },
                success: function() { loadChats(); }
            });
        }
        
        document.getElementById('chatInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendChat();
        });
    </script>
</body>
</html>