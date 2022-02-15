<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function before(User $user): bool
    {
        return $user->hasAccess("platform.client_applications.manage");
    }

    public function __call($method, $args)
    {
        return false;
    }
}
