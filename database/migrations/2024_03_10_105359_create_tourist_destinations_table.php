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
        Schema::create('tourist_destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->string('location');
            $table->string('open_days');
            $table->string('open_time');
            $table->string('ticket_price');
            $table->string('image_asset');
            $table->json('image_urls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_destinations', function (Blueprint $table) {
            $table->time('close_time');
        });
    }
};
