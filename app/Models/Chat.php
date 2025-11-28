<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = []; // Izinkan semua kolom diisi

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}