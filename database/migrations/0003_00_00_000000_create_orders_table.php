<?php

use App\Module\Order\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->noActionOnDelete();
      $table->integer('total');
      $table->enum('status', OrderStatus::cases())->default(OrderStatus::New);
      $table->timestamps();
      $table->timestamp('expires_at');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};
