<?php

use App\Module\Logging\Enums\Action;
use App\Module\Logging\Enums\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('logs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->enum('scope', Scope::cases());
      $table->enum('action', Action::cases());
      $table->text('info');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('logs');
  }
};
