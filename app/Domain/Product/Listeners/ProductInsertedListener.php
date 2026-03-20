<?php

namespace App\Listeners\CMS;

use App\Domain\Product\Events\ProductInserted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductInsertedListener implements ShouldQueue
{
    use InteractsWithQueue;
    public $tries = 3;
    public $backoff = 30;

    public function handle(ProductInserted $event)
    {
        // Job
    }
}
