<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Chat; // Pastikan model Chat di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CourierController extends Controller
{
    // ==========================================
    // 1. HALAMAN UTAMA (HOME / BURSA ORDER)
    // ==========================================
    public function index()
    {
        // Orderan baru (Pending)
        $availableOrders = Order::where('status', 'pending')
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        // Hitung pendapatan hari ini untuk Widget Header
        $todayEarnings = Order::where('courier_id', Auth::id())
                              ->where('status', 'completed')
                              ->whereDate('updated_at', Carbon::today())
                              ->sum('ongkir');

        return view('courier.index', compact('availableOrders', 'todayEarnings'));
    }

    // ==========================================
    // 2. HALAMAN TUGAS AKTIF
    // ==========================================
    public function active()
    {
        $myActiveOrders = Order::where('courier_id', Auth::id())
                               ->where('status', 'taken')
                               ->get();

        return view('courier.active', compact('myActiveOrders'));
    }

    // ==========================================
    // 3. HALAMAN RIWAYAT
    // ==========================================
    public function history()
    {
        $histories = Order::where('courier_id', Auth::id())
                          ->where('status', 'completed')
                          ->orderBy('updated_at', 'desc')
                          ->get();

        return view('courier.history', compact('histories'));
    }

    // ==========================================
    // 4. HALAMAN PROFIL
    // ==========================================
    public function profile()
    {
        $totalEarnings = Order::where('courier_id', Auth::id())
                              ->where('status', 'completed')
                              ->sum('ongkir');
                              
        $completedCount = Order::where('courier_id', Auth::id())
                               ->where('status', 'completed')
                               ->count();

        return view('courier.profile', compact('totalEarnings', 'completedCount'));
    }

    // ==========================================
    // 5. AKSI TOMBOL (AMBIL & SELESAI)
    // ==========================================
    public function takeOrder($id)
    {
        $order = Order::find($id);
        if($order->status == 'pending') {
            $order->update(['status' => 'taken', 'courier_id' => Auth::id()]);
            // Redirect ke halaman Tugas Aktif setelah ambil
            return redirect()->route('kurir.active')->with('success', 'Order diambil! Segera proses.');
        }
        return back()->with('error', 'Telat! Sudah diambil orang lain.');
    }

    public function completeOrder($id)
    {
        $order = Order::where('id', $id)->where('courier_id', Auth::id())->first();
        if($order) {
            $order->update(['status' => 'completed']);
            return back()->with('success', 'Pekerjaan selesai! Saldo bertambah.');
        }
        return back();
    }

    // ==========================================
    // 6. FITUR CHAT (INTEGRASI WA FONNTE)
    // ==========================================

    // A. Ambil Data Chat (Untuk AJAX Load)
    public function getChats($orderId)
    {
        $chats = Chat::where('order_id', $orderId)
                     ->orderBy('created_at', 'asc')
                     ->get();
        return response()->json($chats);
    }

    // B. Kirim Pesan (Simpan DB + Kirim WA)
    public function sendChat(Request $request, $orderId)
    {
        $request->validate(['message' => 'required']);
        $order = Order::find($orderId);

        // 1. Simpan ke Database Lokal (Supaya muncul di box chat kurir)
        Chat::create([
            'order_id' => $orderId,
            'sender' => 'courier',
            'message' => $request->message
        ]);

        // 2. Kirim ke WhatsApp Pelanggan (Via Fonnte)
        try {
            $this->sendToWhatsapp($order->whatsapp_number, $request->message);
        } catch (\Exception $e) {
            // Error handling diam-diam agar aplikasi tidak crash
        }

        return response()->json(['status' => 'success']);
    }

    // C. Fungsi Teknis API Fonnte (VERSI BERSIH - TANPA EMBEL-EMBEL)
    private function sendToWhatsapp($target, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'target' => $target,
            // PESAN BERSIH (Sesuai ketikan kurir)
            'message' => $message, 
          ),
          CURLOPT_HTTPHEADER => array(
            // ⚠️⚠️⚠️ PENTING: GANTI KODE DI BAWAH INI DENGAN TOKEN ASLI ANDA ⚠️⚠️⚠️
            'Authorization: fJHJZue6eSooFJHwVAWQ' 
          ),
        ));

        $response = curl_exec($curl);
        
        // Debugging: Jika pesan tidak terkirim, uncomment (buka) baris di bawah ini untuk lihat errornya di layar
        // if (curl_errno($curl)) { dd(curl_error($curl)); }
        // dd($response); 

        curl_close($curl);
    }
}