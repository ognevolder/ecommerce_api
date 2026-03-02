<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        // Scenario B: Створюємо Orders для існуючих користувачів
        foreach ($users as $user) {
            Order::factory()
                ->count(2)
                ->withItems(3)
                ->create([
                    'user_id' => $user->id,
                ])
                ->each(function ($order) use ($products) {
                    // Підрахунок total_price
                    $total = $order->items->sum(fn($item) => $item->price * $item->quantity);
                    $order->update(['total_price' => $total]);
                });
        }

        // Scenario A: Створюємо Order для випадкового User
        // якщо юзерів немає, фабрика сама створить одного
        Order::factory()
            ->count(2)
            ->withItems(3)
            ->create();
    }
}
