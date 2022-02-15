<?php

namespace App\Modules\Api\Article\Input;

interface ArticleInputInterface
{
    /**
     * Download Article from Api
     *
     * @param string $q Query string
     * @param string $date_from Date from  Y-m-d
     * @param string $date_to DateTo Y-m-d
     * @param string $sort_by Sort By
     *
     *
     * @return string Download Result
     */
    public function load(string $q, string  $date_from, string $date_to, string $sort_by): string;
}
