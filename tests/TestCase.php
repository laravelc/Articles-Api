<?php

namespace Tests;

use App\Models\ClientApplication;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\AuthorSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithFaker;

    /**
     * Ключ приложения, который подключается
     *
     * @var string
     */
    protected string $applicationKey;

    /**
     * Дата отправки
     * @var string
     */
    public string $date_time;


    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->date_time = date('Y-m-d\TH:i:s.uP', time());

        $clientApplication = ClientApplication::factory()->create();
        $clientApplication->update([
            'permissions' => [
                'api.client_applications.manage' => true,
                'api.articles.manage' => true,
                'api.authors.manage' => true
            ]
        ]);
        $this->applicationKey = $clientApplication->firstKey();


        $clientApplication->save();

        $this->callSeeder(CategorySeeder::class, $clientApplication->id);
        $this->callSeeder(AuthorSeeder::class, $clientApplication->id);
        $this->callSeeder(ArticleSeeder::class, $clientApplication->id);

        $this->applicationId = $clientApplication->id;
    }

    /**
     * Вызов seeder с параметром
     * @throws BindingResolutionException
     */
    private function callSeeder($class, $param)
    {
        app()->make($class)->call($class, false, [$param]);
    }
}
