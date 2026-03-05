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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_price');
            $table->enum('status', [
                \App\Enums\OrderStatus::New->value,
                \App\Enums\OrderStatus::Pending->value,
                \App\Enums\OrderStatus::Fulfilled->value,
                \App\Enums\OrderStatus::Canceled->value
            ])->default(\App\Enums\OrderStatus::New->value);
            $table->enum('payment_status', [
                \App\Enums\PaymentStatus::Pending->value,
                \App\Enums\PaymentStatus::Paid->value
            ])->default(\App\Enums\PaymentStatus::Pending->value);
            $table->timestamps();
            $table->timestamp('expires_at');
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
