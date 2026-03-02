<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first()
                ?? User::factory()->create();
        return [
            'user_id' => $user->id,
            'total_price' => 0,
            'status' => fake()->randomElement(['Pending', 'Paid'])
        ];
    }

    public function withItems(int $count = 3)
    {
        return $this->has(OrderItem::factory()->count($count), 'items');
    }

    public function configure()
    {
        return $this->afterCreating(function ($order)
        {
            $total = $order->items->sum(
                fn($item) => $item->price * $item->quantity
            );

            $order->update([
                'total_price' => $total
            ]);
        });
    }
}
