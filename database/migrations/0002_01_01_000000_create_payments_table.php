<?php

use App\Domain\Payment\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
      $table->foreignId('order_id')->constrained()->cascadeOnDelete();
      $table->enum('status', PaymentStatus::cases())->default(PaymentStatus::AWAITING);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('payments');
  }
};
