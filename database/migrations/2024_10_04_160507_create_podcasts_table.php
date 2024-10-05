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
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title' , 256);
            $table->foreignId('show_id')->nullable()->constrained();
            $table->foreignId('artist_id')->constrained();
            $table->string('cover' , 256);
            $table->string('file' , 256);
            $table->text('lyric')->nullable();
            $table->text('About')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podcasts');
    }
};
