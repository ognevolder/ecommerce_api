<?php

namespace App\Listeners\CMS;

use App\Actions\CMS\LogProductInsertionAction;
use App\Events\CMS\ProductInserted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductInsertedListener implements ShouldQueue
{
    use InteractsWithQueue;
    public $tries = 3;
    public $backoff = 30;

    public function handle(ProductInserted $event)
    {
        $action = new LogProductInsertionAction();
        $action->execute($event);
    }
}
