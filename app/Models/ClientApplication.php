<?php

namespace App\Models;

use Database\Factories\ClientApplicationFactory;
use Givebutter\LaravelKeyable\Keyable;
use Givebutter\LaravelKeyable\Models\ApiKey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Orchid\Access\UserAccess;
use Orchid\Access\UserInterface;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\Role;
use Orchid\Screen\AsSource;

/**
 * Список приложений для авторизации Api
 *
 * @OA\Schema (description="Приложение для авторизации Api", required={"name", "callback_url"}, @OA\Xml(name="ClientApplication"),
 * @OA\Property (property="id", type="integer", description="ID клиентского приложения"),
 * @OA\Property (property="name", type="string", description="Название клиентского приложения"),
 * @OA\Property (property="callback_url", type="string", description="URL для передачи событий по webhook с клиентского приложения"),
 * @OA\Property (property="created_at", type="date", example="2022-01-22T20:30:44+0300", description="Дата создания")
 * )
 * @property int $id
 * @property string $name
 * @property string|null $callback_url
 * @property array|null $permissions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ApiKey[] $apiKeys
 * @property-read int|null $api_keys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|ClientApplication byAccess(string $permitWithoutWildcard)
 * @method static Builder|ClientApplication byAnyAccess($permitsWithoutWildcard)
 * @method static Builder|ClientApplication defaultSort(string $column, string $direction = 'asc')
 * @method static ClientApplicationFactory factory(...$parameters)
 * @method static Builder|ClientApplication filters(?HttpFilter $httpFilter = null)
 * @method static Builder|ClientApplication filtersApply(iterable $filters = [])
 * @method static Builder|ClientApplication filtersApplySelection($selection)
 * @method static Builder|ClientApplication newModelQuery()
 * @method static Builder|ClientApplication newQuery()
 * @method static \Illuminate\Database\Query\Builder|ClientApplication onlyTrashed()
 * @method static Builder|ClientApplication query()
 * @method static Builder|ClientApplication whereCallbackUrl($value)
 * @method static Builder|ClientApplication whereCreatedAt($value)
 * @method static Builder|ClientApplication whereDeletedAt($value)
 * @method static Builder|ClientApplication whereId($value)
 * @method static Builder|ClientApplication whereName($value)
 * @method static Builder|ClientApplication wherePermissions($value)
 * @method static Builder|ClientApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ClientApplication withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ClientApplication withoutTrashed()
 * @mixin \Eloquent
 */
class ClientApplication extends Model implements UserInterface
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use SoftDeletes;
    use UserAccess;
    use Keyable;

    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'callback_url',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected array $allowedFilters = [
        'id',
        'name',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected array $allowedSorts = [
        'id',
        'name',
        'updated_at',
        'created_at',
    ];

    /**
     * Создать ключ Api
     * @param array $permissions
     * @return mixed
     */
    public static function createApplicationKey(
        array $permissions = []
    ): mixed {
        $application = self::createClientApplication($permissions);
        return $application->firstKey();
    }

    /**
     * @param array $permissions
     * @return Collection|Model
     */
    public static function createClientApplication(
        array $permissions = []
    ): Model|Collection {
        $application = ClientApplication::factory()->create();
        $perms = [];

        foreach ($permissions as $permission) {
            $perms[$permission] = true;
        }

        $perms['api.applications.view'] = true;
        $application->permissions = $perms;
        $application->save();

        return $application;
    }

    /**
     * Ключ из БД
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function firstKey(): mixed
    {
        $api_key = $this->apiKeys()->first();
        if (!$api_key) {
            return null;
        }
        return $api_key->key;
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Dashboard::model(Role::class),
            'role_client_applications',
            'client_application_id',
            'role_id'
        );
    }
}
