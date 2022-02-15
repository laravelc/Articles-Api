<?php

namespace App\Modules\Api\Article\ArticleList;

use App\Models\Category;
use App\Modules\API\Article\Input\ArticleApiInput;
use Generator;

/**
 * Articles List
 */
class ArticlesList
{
    /**
     * Download Article from Api
     *
     * @param ArticleApiInput $input Input
     * @param Category[] $categories Categories
     * @param string $date DateTo Y-m-d
     *
     *
     * @return Generator|string Download Result
     */
    public static function article_lists(ArticleApiInput $input, array $categories, string $date): Generator|string
    {
        foreach ($categories as $category) {
            yield (object)['category_id' => $category->id , 'content' => $input->load($category->name, $date, $date, 'popularity')];
        }
    }
}
