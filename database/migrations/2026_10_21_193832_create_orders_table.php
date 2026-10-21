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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_number', 30)->unique();
            $table->enum('status', ['new', 'processing', 'sent', 'done', 'cancelled'])->default('new');
            $table->string('customer_name', 100);
            $table->string('customer_email', 100)->default('');
            $table->string('phone', 30);
            $table->string('city', 100);
            $table->string('street', 150);
            $table->string('house', 50);
            $table->string('flat', 50)->default('');
            $table->text('comment')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
