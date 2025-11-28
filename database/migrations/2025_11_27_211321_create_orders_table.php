<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('item_name');
            $table->string('whatsapp_number');
            $table->text('pickup_location');
            $table->text('dropoff_location');
            $table->integer('ongkir');
            
            // --- INI TAMBAHANNYA ---
            $table->integer('distance')->nullable(); // Kolom Jarak
            // ------------------------

            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'taken', 'completed'])->default('pending');
            $table->foreignId('courier_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};