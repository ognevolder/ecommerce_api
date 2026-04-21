<?php

namespace App\Console\Commands;

use App\Module\Cart\Models\CartItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReleaseExpiredCartItemsCommand extends Command
{
  protected $signature = 'cart:release-expired';

  protected $description = 'Release expired cart items and reserved stock';

  public function handle(): int
  {
    CartItem::where('expires_at', '<', now())
      ->whereNull('released_at')
      ->chunkById(100, function ($items) {

      foreach ($items as $item)
      {
        DB::transaction(function () use ($item)
        {
          $product = $item->product()
            ->lockForUpdate()
            ->first();

          if (! $product) {
            return;
          }

          if ($item->released_at !== null) {
            return;
          }

          $product->decrement('reserved', $item->quantity);

          $item->update([
              'released_at' => now()
            ]);
        });
      }
    });

    return self::SUCCESS;
  }
}