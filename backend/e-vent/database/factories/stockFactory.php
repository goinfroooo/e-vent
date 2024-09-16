<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\stock>
 */
class stockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $article_ids = Article::pluck('id')->toArray();
        return [
            'article_id' => $this->faker->unique()->randomElement($article_ids),
            'qte' => $this->faker->numberBetween(1, 30),
            // Ajoutez d'autres champs de votre modèle player_status ici
        ];
        
    }
}
