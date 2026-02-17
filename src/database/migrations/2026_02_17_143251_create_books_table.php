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
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('pages')->nullable();
            $table->string('publisher')->nullable();
            $table->date('published_at')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('book_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_tag');
        Schema::dropIfExists('books');
    }
};
