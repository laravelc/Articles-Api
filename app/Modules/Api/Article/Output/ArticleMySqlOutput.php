<?php

namespace App\Modules\Api\Article\Output;

use App\Models\{Article, Author};
use DateTime;
use Exception;

/**
 * To save articles
 */
class ArticleMySqlOutput implements ArticleOutputInterface
{
    /**
     * Save Articles
     * @param array $array Array
     * @param string $category_id Category
     *
     * @return void
     * @throws Exception
     */
    public function execute(array $array, string $category_id): void
    {
        foreach ($array as $item) {
            $article = new Article();

            $article->title = $item['title'];
            $article->source = $item['source']['name'];

            if ($item['author']) {
                $article->author_id = Author::updateOrCreate(['name' => $item['author']])->id;
            }


            $article->description = $item['description'];
            $article->url = $item['url'];
            $article->image_url = $item['urlToImage'];

            $article->category_id = $category_id;
            $article->published_at = new DateTime('@' . strtotime($item['publishedAt'])); //TZ time format
            $article->content = $item['content'];

            $article->save();
        }
    }
}
