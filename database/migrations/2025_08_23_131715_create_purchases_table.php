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
    Schema::create('purchases', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('supplier_id');
        $table->date('purchase_date');
        $table->string('status')->default('pending'); // pending | confirmed
        $table->timestamps();

        $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
    });

    Schema::create('purchase_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('purchase_id');
        $table->unsignedBigInteger('product_id');
        $table->integer('quantity');
        $table->timestamps();

        $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

};