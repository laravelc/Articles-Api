<?php

namespace App\Policies\KeyablePolicies;

use App\Models\ClientApplication;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(ClientApplication $keyable): bool
    {
        return $keyable->hasAccess("api.client_applications.view");
    }

    public function __call($method, $args)
    {
        return false;
    }
}
