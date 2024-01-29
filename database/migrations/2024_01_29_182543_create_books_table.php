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
            $table->decimal('isbn_code', 13, 9)->unique()->nullable(false);
            $table->dateTime('added_at');
            $table->dateTime('deleted_at')->default(null);
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
