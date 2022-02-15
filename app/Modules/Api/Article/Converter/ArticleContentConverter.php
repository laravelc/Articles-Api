<?php

namespace App\Modules\Api\Article\Converter;

/**
 * Convert content
 */
class ArticleContentConverter implements ArticleContentConverterInterface
{
    /**
     * Convert json to Array
     * @param string $json
     * @return array
     */
    public function convert(string $json): array
    {
        $response = json_decode($json, true);

        return $response['articles'];
    }
}
