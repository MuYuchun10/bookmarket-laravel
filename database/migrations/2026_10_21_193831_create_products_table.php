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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('author', 150);
            $table->text('description')->nullable();
            $table->text('full_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image', 255)->nullable();
            $table->integer('quantity')->default(0);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_hit')->default(false);
            $table->boolean('status')->default(true);
            $table->string('publisher', 150)->default('');
            $table->year('publication_year')->nullable();
            $table->integer('pages')->nullable();
            $table->string('language', 50)->default('Русский');
            $table->string('cover_type', 50)->default('');
            $table->string('article', 50)->default('');
            $table->timestamps();

            $table->index('category_id');
            $table->index('status');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
