<?php

namespace App\Modules\Api\Article\Output;

interface ArticleOutputInterface
{
    /**
     * Save Articles
     * @param array $array Array
     * @param string $category_id Category
     *
     * @return void
     */
    public function execute(array $array, string $category_id): void;
}
