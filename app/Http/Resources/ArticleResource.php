<?php

namespace App\Http\Resources;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * Статья
 *
 * @OA\Schema(description="Статья", required={"id", "content", "status", "authors", "created_at", "scheduled_at"}, @OA\Xml(name="ArticleResponse"),
 * @OA\Property(property="id", type="integer", example="1"),
 * @OA\Property(property="status", type="string", example="CREATED"),
 * @OA\Property(property="title", type="string", example="Название статьи"),
 * @OA\Property(
 *          property="authors",
 *          description="Автор",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/Author")
 * ),
 * @OA\Property(
 *          property="categories",
 *          description="Категория",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/Category")
 * )
 * )
 * @mixin Eloquent
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'source' => $this->source,
            'description' => $this->description,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'published_at' => $this->published_at,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'type_name' => $this->type_name,
            "categories" => CategoryResource::collection($this->whenLoaded('categories')),
            'authors' => AuthorResource::collection($this->whenLoaded('authors')),
        ];
    }
}
