<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('couriers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone');
        $table->string('email')->nullable();
        $table->text('address')->nullable();
        $table->timestamps();
    });

    Schema::table('orders', function (Blueprint $table) {
        $table->unsignedBigInteger('courier_id')->nullable()->after('payment_method');
        $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};