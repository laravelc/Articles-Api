<?php

namespace App\Modules\Api\Article;

interface ArticlesManagerInterface
{
    /**
     * Update Article from Api
     * @return void
     */
    public function handle(): void;
}
