<?php

namespace App\Application\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:64'],
      'email' => ['required', 'string', 'email', 'unique:users'],
      'password' => ['required', 'string', 'min:6']
    ];
  }
}
