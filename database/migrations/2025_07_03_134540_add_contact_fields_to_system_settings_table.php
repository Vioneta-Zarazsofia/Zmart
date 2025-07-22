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
    Schema::table('system_settings', function (Blueprint $table) {
        $table->string('contact_title')->nullable();
        $table->text('contact_description')->nullable();
        $table->string('contact_image')->nullable();
    });
}

public function down()
{
    Schema::table('system_settings', function (Blueprint $table) {
        $table->dropColumn(['contact_title', 'contact_description', 'contact_image']);
    });
}

};