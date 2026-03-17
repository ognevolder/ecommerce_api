<?php

use App\Domain\Product\Enums\ProductState;
use App\Domain\Product\Enums\ProductStatus;
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
            $table->string('title');
            $table->text('description');
            $table->decimal('price');
            $table->integer('stock')->default(0);
            $table->integer('reserved')->default(0);
            $table->enum('status', [
                ProductStatus::AVAILABLE,
                ProductStatus::SOLD,
                ProductStatus::BACKORDERED,
                ProductStatus::RESERVED
            ])->default(ProductStatus::AVAILABLE);
            $table->enum('state', [
                ProductState::PUBLIC,
                ProductState::DRAFT,
                ProductState::ARCHIVED
            ])->default(ProductState::PUBLIC);
            $table->timestamps();
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
