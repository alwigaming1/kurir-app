<div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-6 py-2 flex justify-between items-center z-50 max-w-[480px] left-0 right-0 mx-auto shadow-[0_-5px_15px_rgba(0,0,0,0.02)]">
    
    <a href="{{ route('kurir.index') }}" class="flex flex-col items-center gap-1 p-2 w-16 {{ Route::is('kurir.index') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600' }}">
        <i class="fas fa-home text-xl"></i>
        <span class="text-[9px] font-bold">Home</span>
    </a>

    <a href="{{ route('kurir.active') }}" class="flex flex-col items-center gap-1 p-2 w-16 {{ Route::is('kurir.active') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600' }}">
        <div class="relative">
            <i class="fas fa-box-open text-xl"></i>
            @if(Route::is('kurir.active')) <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span> @endif
        </div>
        <span class="text-[9px] font-bold">Tugas</span>
    </a>

    <a href="{{ route('kurir.history') }}" class="flex flex-col items-center gap-1 p-2 w-16 {{ Route::is('kurir.history') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600' }}">
        <i class="fas fa-history text-xl"></i>
        <span class="text-[9px] font-bold">Riwayat</span>
    </a>

    <a href="{{ route('kurir.profile') }}" class="flex flex-col items-center gap-1 p-2 w-16 {{ Route::is('kurir.profile') ? 'text-blue-600' : 'text-gray-400 hover:text-blue-600' }}">
        <i class="fas fa-user text-xl"></i>
        <span class="text-[9px] font-bold">Akun</span>
    </a>

</div>