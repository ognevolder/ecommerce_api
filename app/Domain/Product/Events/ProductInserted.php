<?php

namespace App\Domain\Product\Events;

use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductInserted
{
    use Dispatchable, SerializesModels;

    public $product;
    public $admin_id;
    public $admin_name;

    /**
     * Create a new event instance.
     */
    public function __construct(Product $product, int $admin_id, string $admin_name)
    {
        $this->product = $product;
        $this->admin_id = $admin_id;
        $this->admin_name = $admin_name;
    }
}
