<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\ArticleFactory;
use Givebutter\LaravelKeyable\Keyable;
use Illuminate\Database\Eloquent\{Builder,
    Collection,
    Factories\HasFactory,
    Model,
    Relations\BelongsToMany,
    SoftDeletes};
use Givebutter\LaravelKeyable\Models\ApiKey;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Screen\AsSource;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @OA\Schema (description="Статья", required={"title", "content", "author_id"})
 * @property int $id
 * @property string $title
 * @property string $source
 * @property int $author_id
 * @property string $description
 * @property string $url
 * @property string $image_url
 * @property string $published_at
 * @property string $content
 * @property int $category_id
 * @property string $type_name
 * @property-read BelongsTo $category Category
 * @property-read BelongsTo $author Author
 * @method static Builder|Article fromDate($param)
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article query()
 * @method static Builder|Article searchText($param)
 * @method static Builder|Article toDate($param)
 * @mixin Eloquent
 * @method static Builder|Article typeName($param)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Article whereAuthorId($value)
 * @method static Builder|Article whereCategoryId($value)
 * @method static Builder|Article whereContent($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereDescription($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereImageUrl($value)
 * @method static Builder|Article wherePublishedAt($value)
 * @method static Builder|Article whereSource($value)
 * @method static Builder|Article whereTitle($value)
 * @method static Builder|Article whereTypeName($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @method static Builder|Article whereUrl($value)
 * @property int $creator_id
 * @property Carbon|null $deleted_at
 * @property-read Collection|ApiKey[] $apiKeys
 * @property-read int|null $api_keys_count
 * @property-read Collection|Author[] $authors
 * @property-read int|null $authors_count
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @method static Builder|Article defaultSort(string $column, string $direction = 'asc')
 * @method static ArticleFactory factory(...$parameters)
 * @method static Builder|Article filters(?HttpFilter $httpFilter = null)
 * @method static Builder|Article filtersApply(iterable $filters = [])
 * @method static Builder|Article filtersApplySelection($selection)
 * @method static \Illuminate\Database\Query\Builder|Article onlyTrashed()
 * @method static Builder|Article whereCreatorId($value)
 * @method static Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Article withoutTrashed()
 */
class Article extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use SoftDeletes;
    use Keyable;

    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'source',
        'description',
        'url',
        'image_url',
        'published_at',
        'content',
        'type_name',
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
     * @return belongsToMany Категории
     */
    public function categories(): belongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return belongsToMany Авторы
     */
    public function authors(): belongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * Поиск текста
     * @param $query
     * @param $param
     * @return Builder
     */
    public function scopeSearchText($query, $param): Builder
    {
        return $query->where(function ($query) use ($param) {
            $query
                ->orWhere('title', 'like', '%' . $param . '%')
                ->orWhere('content', 'like', '%' . $param . '%')
                ->orWhere('description', 'like', '%' . $param . '%');

            $query->orWhereHas('author', function ($q) use ($param) {
                $q->where('name', 'like', '%' . $param . '%');
            });

            $query->orWhereHas('category', function ($q) use ($param) {
                $q->where('name', 'like', '%' . $param . '%');
            });
        });
    }

    /** От даты
     *
     * @param $query
     * @param $param
     * @return Builder
     */
    public function scopeFromDate($query, $param): Builder
    {
        return $query->where('published_at', '>=', $param);
    }

    /**
     * До даты
     *
     * @param $query
     * @param $param
     * @return Builder
     */
    public function scopeToDate($query, $param): Builder
    {
        return $query->where('published_at', '<=', $param);
    }

    /**
     * Имя типа
     *
     * @param $query
     * @param $param
     * @return Builder
     */
    public function scopeTypeName($query, $param): Builder
    {
        return $query->where('type_name', $param);
    }


    /**
     * @return mixed Получить случайную категорию
     */
    public static function getRandomType(): string
    {
        return array_rand(['article', 'news']);
    }
}
