<?php

use App\Enums\RoleEnum;
use App\Enums\SubscribtionEnum;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('mobile', 11)->unique()->nullable();
            $table->boolean('two_step_verificaztion')->default(false);
            $table->string('username', 64)->unique();
            $table->string('profile')->nullable();
            $table->enum('subscribtion_plan', [SubscribtionEnum::FREE->value, SubscribtionEnum::PREMIUM->value])->default(SubscribtionEnum::FREE->value);
            $table->timestamp('subscribtion_expired_at')->nullable();
            $table->string('role', 128)->default(RoleEnum::USER->value);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
