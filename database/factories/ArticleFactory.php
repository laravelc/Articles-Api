<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        'title' => "string",
        'source' => "string",
        'description' => "string",
        'url' => "string",
        'image_url' => "string",
        'published_at' => "string",
        'content' => "string",
        'type_name' => "string"
    ])] public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'source' => $this->faker->url(),
            'description' => $this->faker->text(),
            'url' => $this->faker->url(),
            'image_url' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTime(),
            'content' => $this->faker->text(),
            'type_name' => Article::getRandomType(),
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


    /**
     * Тип новостей
     *
     * @return Factory
     */
    public function typeNews(): Factory
    {
        return $this->state(function () {
            return [
                'type_name' => 'news',
            ];
        });
    }

    /**
     * Тип новостей
     *
     * @return Factory
     */
    public function typeArticle(): Factory
    {
        return $this->state(function () {
            return [
                'type_name' => 'article',
            ];
        });
    }
}
