<?php

namespace App\Models;

use Eloquent;
use Givebutter\LaravelKeyable\Keyable;
use Illuminate\Database\Eloquent\{Builder, Collection, Factories\HasFactory, Model, SoftDeletes};
use Givebutter\LaravelKeyable\Models\ApiKey;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Screen\AsSource;

/**
 * App\Models\Author
 *
 * @OA\Schema (description="Автор", required={"name", "email"},
 * @OA\Property (
 *                     property="name",
 *                     type="string"
 *                 ),
 * @OA\Property (
 *                     property="email",
 *                     type="string"
 *                 )
 * )
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $creator_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|ApiKey[] $apiKeys
 * @property-read int|null $api_keys_count
 * @property-read Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @method static Builder|Author defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\AuthorFactory factory(...$parameters)
 * @method static Builder|Author filters(?HttpFilter $httpFilter = null)
 * @method static Builder|Author filtersApply(iterable $filters = [])
 * @method static Builder|Author filtersApplySelection($selection)
 * @method static Builder|Author newModelQuery()
 * @method static Builder|Author newQuery()
 * @method static \Illuminate\Database\Query\Builder|Author onlyTrashed()
 * @method static Builder|Author query()
 * @method static Builder|Author whereCreatedAt($value)
 * @method static Builder|Author whereCreatorId($value)
 * @method static Builder|Author whereDeletedAt($value)
 * @method static Builder|Author whereEmail($value)
 * @method static Builder|Author whereId($value)
 * @method static Builder|Author whereName($value)
 * @method static Builder|Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Author withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Author withoutTrashed()
 * @mixin Eloquent
 */
class Author extends Model
{
    use HasFactory;
    use AsSource, Filterable;
    use SoftDeletes;
    use Keyable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * При действиях с объектом
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if ($model->creator_id === null) {
                $model->creator_id = request()->keyable->id;
            }
        });
    }

    /**
     * @return HasMany Статьи
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Создать если не создано
     * @param array $authors
     * @return array
     */
    public static function getOrCreate(array $authors): array
    {
        $results = [];

        foreach ($authors as $author) {
            $results[] = Author::firstOrCreate(
                ['email' => $author['email'],],
                ['name' => $author['name'], 'email' => $author['email'],]
            )->id;
        }

        return $results;
    }
}
