<?php

use App\Module\Product\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->integer('quantity')->default(1);
      $table->integer('price')->default(1);
      $table->integer('reserved')->default(0);
      $table->enum('status', ProductStatus::cases())->default(ProductStatus::Draft);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('products');
  }
};
