<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_book', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->dateTime('added_at');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_book');
    }
};
