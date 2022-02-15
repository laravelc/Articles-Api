<?php

namespace Database\Seeders;


use App\Models\Author;
use Illuminate\Database\Seeder;

/**
 *  Создать артикли
 */
class AuthorSeeder extends Seeder
{
    /**
     * Авторы
     *
     * @param int $creator_id
     * @return void
     */
    public function run(int $creator_id)
    {
        Author::factory()->withCreatorId($creator_id)->count(5)->create();
    }
}
