<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nickname' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'role'     => User::ROLE_USER,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['role' => User::ROLE_ADMIN]);
    }

    public function moderator(): static
    {
        return $this->state(fn () => ['role' => User::ROLE_MODERATOR]);
    }
}
