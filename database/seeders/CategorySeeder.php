<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 *  Создать артикли
 */
class CategorySeeder extends Seeder
{
    /**
     * Категории
     *
     * @param int $creator_id
     * @return void
     */
    public function run(int $creator_id)
    {
        Category::factory()->withCreatorId($creator_id)->count(5)->create();
    }
}
