<?php

namespace App\Providers;


use App\Models\Article;
use App\Models\Author;
use App\Models\ClientApplication;
use App\Policies\KeyablePolicies\ArticlePolicy;
use App\Policies\KeyablePolicies\AuthorPolicy;
use App\Policies\KeyablePolicies\ClientApplicationPolicy;

use Givebutter\LaravelKeyable\Facades\Keyable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Keyable::registerKeyablePolicies([
            Article::class => ArticlePolicy::class,
            Author::class => AuthorPolicy::class,
            ClientApplication::class => ClientApplicationPolicy::class,
        ]);
    }
}
