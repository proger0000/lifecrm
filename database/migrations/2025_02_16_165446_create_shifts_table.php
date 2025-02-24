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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id'); // ID поста, к которому назначается смена
            $table->date('shift_date'); // Дата смены
            $table->timestamp('scheduled_start_time')->nullable(); // Планируемое время начала смены
            $table->timestamp('scheduled_end_time')->nullable();   // Планируемое время окончания смены
            $table->timestamp('check_in_time')->nullable();  // Фактическое время прихода
            $table->timestamp('check_out_time')->nullable(); // Фактическое время ухода
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Если у вас есть таблица для постов, создайте внешний ключ для post_id
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
