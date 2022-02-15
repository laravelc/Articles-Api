<?php

namespace App\Http\Resources;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Статья
 *
 * @OA\Schema(description="Категория", required={"id", "name"}, @OA\Xml(name="CategoryResponse"))
 *
 *
 * @mixin Eloquent
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(["name" => "mixed"])] public function toArray($request): array
    {
        return [
            "name" => $this->name,
        ];
    }
}
