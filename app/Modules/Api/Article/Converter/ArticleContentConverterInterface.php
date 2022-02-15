<?php

namespace App\Modules\Api\Article\Converter;

interface ArticleContentConverterInterface
{
    /**
     * Convert json to Array
     * @param string $json
     * @return array
     */
    public function convert(string $json): array;
}
