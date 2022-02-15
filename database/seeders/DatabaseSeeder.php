<?php

namespace Database\Seeders;

use App\Models\ClientApplication;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Общий
     *
     * @return void
     */
    public function run()
    {
        $clientApplication = ClientApplication::factory()->create();
        $clientApplication->update([
            'api.client_applications.manage' => true,
            'api.articles.manage' => true,
            'api.authors.manage' => true,
            'platform.client_applications.manage' => true,
            'platform.articles.manage' => true,
            'platform.authors.manage' => true,
        ]);

        $this->call([
            CategorySeeder::class,
            AuthorSeeder::class,
            ArticleSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ], false, ['creator_id' => $clientApplication->id]);
    }
}
