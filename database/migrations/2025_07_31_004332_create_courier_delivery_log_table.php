<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courier_delivery_log', function (Blueprint $table) {
    $table->id();
    $table->foreignId('courier_id')->constrained('couriers');
    $table->foreignId('order_id')->constrained('orders');
    $table->foreignId('product_id')->constrained('product');
    $table->integer('quantity'); // Bisa positif saat tambah, negatif saat selesai
    $table->date('delivered_date');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_delivery_log');
    }
};