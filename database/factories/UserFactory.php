<?php

namespace Database\Factories;

use App\Module\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
  protected $model = User::class;

  public function definition(): array
  {
    return [
      'name' => fake()->name(),
      'email' => fake()->unique()->safeEmail(),
      'password' => '12345678'
    ];
  }

  // public function withOrders(int $orderCount = 1, int $itemsPerOrder = 3)
  // {
  //   return $this->has(
  //     Order::factory()
  //       ->count($orderCount)
  //       ->withItems($itemsPerOrder),
  //     'orders'
  //   );
  // }

}
