<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Str;
use Faker\Guesser\Name;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\article>
 */
class articleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = FakerFactory::create();

        return [
            "nom" =>$faker->word(),
            "prix" =>$faker->numberBetween(1, 50000),
            "short_description" =>$faker->sentence(30),
            "description" =>$faker->sentence(100),
            "token" => Str::random(10),
            "stripe_id" => Str::random(10),
            "options" =>"",

        ];
    }
}
