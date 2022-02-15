<?php

namespace App\Models;

use Givebutter\LaravelKeyable\Keyable;
use Illuminate\Database\Eloquent\{Builder, Collection, Factories\HasFactory, Model, SoftDeletes};
use Givebutter\LaravelKeyable\Models\ApiKey;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Category
 *
 * @OA\Schema (description="Категория", required={"name", "email"},
 * @OA\Property (
 *                     property="name",
 *                     type="string"
 *                 )
 * )
 * @property int $id
 * @property string $name
 * @property int $creator_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|ApiKey[] $apiKeys
 * @property-read int|null $api_keys_count
 * @property-read Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @method static Builder|Category defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static Builder|Category filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static Builder|Category filtersApply(iterable $filters = [])
 * @method static Builder|Category filtersApplySelection($selection)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereCreatorId($value)
 * @method static Builder|Category whereDeletedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @mixin \Eloquent
 */
class Category extends Model
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
     * @param array $categories
     * @return array Идентификаторы
     */
    public static function getOrCreate(array $categories): array
    {
        $results = [];

        foreach ($categories as $category) {
            $results[] = Category::firstOrCreate(
                ['name' => $category['name'],],
                ['name' => $category['name'],])
                ->id;
        }

        return $results;
    }
}
