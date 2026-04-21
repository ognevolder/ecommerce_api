<?php

namespace App\Module\Auth\Services;

use App\Module\Auth\DTOs\UserRegistrationDTO;
use App\Module\Auth\Events\UserRegistrationEvent;
use App\Module\Auth\Models\User;
use App\Module\Cart\Models\Cart;

class RegistrationService
{
  public function __invoke(UserRegistrationDTO $dto): User
  {
    // --- Action. Registration
    $user = User::create([
      'name' => $dto->name,
      'email' => $dto->email,
      'password' => $dto->password
    ])->fresh();

    // --- Action. Cart creation
    Cart::create([
      'user_id' => $user->id
    ]);

    // --- Event.
    event(new UserRegistrationEvent($user));

    // --- Return.
    return $user;
  }
}