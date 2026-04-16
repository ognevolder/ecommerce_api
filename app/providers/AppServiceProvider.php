<?php

namespace App\Providers;

use App\Module\Product\Models\Product;
use App\Presentation\Http\Policies\Product\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    //
  }

  public function boot(): void
  {
    Gate::policy(
      class: Product::class,
      policy: ProductPolicy::class);
  }
}