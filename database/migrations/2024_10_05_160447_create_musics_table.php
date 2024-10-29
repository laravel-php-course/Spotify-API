<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('musics', function (Blueprint $table) {
            $table->id();
            $table->string('title' , 256);
            $table->foreignId('album_id')->nullable()->constrained();
            $table->foreignId('artist_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->string('cover' , 256);
            $table->string('file' , 256);
            $table->string('producer' , 128);
            $table->text('lyric')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('music');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
