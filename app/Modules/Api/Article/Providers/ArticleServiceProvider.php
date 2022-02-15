<?php

namespace App\Modules\Api\Article\Providers;

use App\Modules\API\Article\ArticleManager;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ArticleManager::class, function () {
            return new ArticleManager();
        });
    }
}
