<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\ClientApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->userName(),
            'email' => $this->faker->email(),
        ];
    }

    /**
     * С идентификиатором создателя
     *
     * @param int $created_id
     * @return Factory
     */
    public function withCreatorId(int $created_id): Factory
    {
        return $this->state(function () use($created_id){
            return [
                'creator_id' => $created_id,
            ];
        });
    }

}
