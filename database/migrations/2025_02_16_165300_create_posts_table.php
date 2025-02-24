<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Запуск миграции.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Название поста (например, "Пляж №1")
            $table->decimal('latitude', 10, 7);  // Широта
            $table->decimal('longitude', 10, 7); // Долгота
            $table->timestamps();
        });
    }

    /**
     * Откат миграции.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
