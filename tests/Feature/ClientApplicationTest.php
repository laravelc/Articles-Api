<?php

namespace Tests\Feature;

use App\Models\ClientApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ClientApplicationTest extends TestCase
{
    /**
     * Проверка создания ключа Api
     * @param array $permissions
     * @return mixed
     */
    public function testCreateApiKey(array $permissions = []): mixed
    {
        $application = ClientApplication::factory()->create();
        $apiKey = $application->firstKey();
        $this->assertNotNull($apiKey, "Ключ не создался");

        return $apiKey;
    }

    /**
     * Доступ с ключем - неверный ключ
     *
     * @return void
     */
    public function testBadNoCreated()
    {
        ClientApplication::factory(4)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer bad-phrase',
        ])->get('/api/app', []);

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
