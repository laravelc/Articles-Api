<?php

namespace App\Modules\Api\Article;

use App\Models\{Article, Author, Category};
use App\Modules\Api\Article\{Output\ArticleMySqlOutput};
use App\Modules\Api\Article\ArticleList\ArticlesList;
use App\Modules\Api\Article\Converter\ArticleContentConverter;
use App\Modules\Api\Article\Input\ArticleApiInput;
use Exception;

/**
 * Article Service Manager
 */
class ArticleManager implements ArticlesManagerInterface
{
    private ArticleContentConverter $converter;
    private ArticleApiInput $input;
    private ArticleMySqlOutput $output;

    public function __construct(ArticleContentConverter $converter, ArticleMySqlOutput $output, ArticleApiInput $input)
    {
        $this->converter = $converter;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * Update Article from Api
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $date = date('Y-m-d');

        $categories = Category::all();

        Article::query()->delete();
        Author::query()->delete();

        $articles = ArticlesList::article_lists($this->input, $categories, $date);

        foreach ($articles as $article) {
            $this->output->execute($this->converter->convert($article->content), $article->category_id);
        }
    }

}
