<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Database\Seeder;

/**
 *  Создать артикли
 */
class ArticleSeeder extends Seeder
{
    /**
     * Статьи
     *
     * @param int $creator_id
     * @return void
     */
    public function run(int $creator_id)
    {
        $authors = Author::all();
        $categories = Category::all();

        Article::factory()->withCreatorId($creator_id)->create()->each(function ($article) use ($authors, $categories) {
            $article->authors()->saveMany(
                $authors->random(rand(1, 5))
            );
            $article->categories()->saveMany(
                $categories->random(rand(1, 5))
            );
        });
    }
}
