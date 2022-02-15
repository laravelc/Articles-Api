<?php

namespace Database\Factories;

use App\Models\ClientApplication;
use Givebutter\LaravelKeyable\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ClientApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string", 'callback_url' => "string"])] public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'callback_url' => 'http://localhost:81/callback',
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): ClientApplicationFactory
    {
        return $this->afterMaking(function (ClientApplication $application) {
        })->afterCreating(function (ClientApplication $application) {
             (new ApiKey)->create([
                'keyable_id' => $application->id,
                'keyable_type' => ClientApplication::class,
                'key' => base64_encode(openssl_random_pseudo_bytes(16)),
            ]);
        });
    }
}
