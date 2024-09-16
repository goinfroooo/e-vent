<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Adress;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = FakerFactory::create();
        $adress_ids = Adress::pluck('id')->toArray();
        return [
            'name' => fake()->name(),
            'birthday' => $faker->dateTimeBetween('-90 years', '-18 years')->format('Y-m-d'),
            'email' => fake()->unique()->safeEmail(),
            'mail_token' => Str::random(10),
            'email_verified_at' => now(),
            'adresse_livraison_id' => $faker->unique()->randomElement($adress_ids),
            'adresse_facturation_id' => $faker->unique()->randomElement($adress_ids),
            'phone' => $faker->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
