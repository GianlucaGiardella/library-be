<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 80)->nullable(false);
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->char('isbn_code', 17)->unique()->nullable(false);
            $table->text('plot');
            $table->smallInteger('readings');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
