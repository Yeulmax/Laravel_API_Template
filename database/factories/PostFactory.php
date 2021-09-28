<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'        => $this->faker->sentence(4, true),
            'content'      => $this->faker->paragraphs(3, true),
            'created_by'   => $this->faker->numberBetween(1, 5),
            'is_public'    => $this->faker->boolean(60)
        ];
    }
}
