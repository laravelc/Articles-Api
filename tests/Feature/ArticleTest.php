<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * Идентификаторы СМС-сообщений
     * @var array
     */
    private array $article_ids;

    /**
     * Установка начальных данных для теста
     * @return void
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->article_ids = Article::select('id')->get()->pluck('id')->toArray();
    }


    /**
     * Создание запланированного сообщения
     * @return void
     */
    public function testsCreateArticle()
    {
        $payload = [
            'title' => $this->faker->title(),
            'source' => $this->faker->url(),
            'description' => $this->faker->text(),
            'url' => $this->faker->url(),
            'image_url' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTime()->format("Y-m-d\TH:i:s.uP"),
            'content' => $this->faker->text(),
            'type_name' => 'news',
            'categories' => [
                [
                    'name' => Article::getRandomType(),
                ],
                [
                    'name' => Article::getRandomType(),
                ]
            ],
            'authors' => [
                [
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                ],
                [
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                ]
            ],
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->applicationKey,
        ])->json('post', '/api/article', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'title',
                    'source',
                    'description',
                    'categories',
                    'authors',
                ]
            ]);
    }

    /**
     * Получение сообщения
     * @return void
     */
    public function testGetArticle()
    {
        foreach ($this->article_ids as $article_id) {
            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->applicationKey,
            ])->json('get', '/api/article/' . $article_id)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'title',
                        'source',
                        'description',
                        'categories',
                        'authors',
                    ]
                ]);
        }
    }


    /**
     * Обновление сообщения
     * @return void
     **/
    public function testUpdateArticle()
    {
        $payload = [
            'title' => $this->faker->title(),
            'source' => $this->faker->url(),
            'description' => $this->faker->text(),
            'url' => $this->faker->url(),
            'image_url' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTime()->format("Y-m-d\TH:i:s.uP"),
            'content' => $this->faker->text(),
            'type_name' => 'news',
            'categories' => [
                [
                    'name' => Article::getRandomType(),
                ],
                [
                    'name' => Article::getRandomType(),
                ]
            ],
            'authors' => [
                [
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                ],
                [
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                ]
            ],
        ];

        foreach ($this->article_ids as $article_id) {
            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->applicationKey,
            ])->json('put', '/api/article/' . $article_id, $payload)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'title',
                        'source',
                        'description',
                        'categories',
                        'authors',
                    ]
                ]);
        }
    }


    /**
     * Отмена отправки сообщения
     * @return void
     */
    public function testDeleteArticles()
    {
        foreach ($this->article_ids as $article_id) {
            $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->applicationKey,
            ])->json('delete', '/api/article/' . $article_id)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                    ],
                ]);
        }
    }
}
