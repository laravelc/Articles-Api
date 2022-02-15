<?php

namespace App\Policies\KeyablePolicies;

use App\Models\ClientApplication;
use Givebutter\LaravelKeyable\Models\ApiKey;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * @param ApiKey $apiKey
     * @return bool
     */
    public function author(ApiKey $apiKey): bool
    {
        $application = $apiKey->keyable;
        return $application->hasAccess("api.authors.manage");
    }
}
