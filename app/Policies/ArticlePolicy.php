<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function before(User $user): bool
    {
        return $user->hasAccess("platform.articles.manage");
    }

    public function __call($method, $args)
    {
        return false;
    }
}
