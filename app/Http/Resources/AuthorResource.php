<?php

namespace App\Http\Resources;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Статья
 *
 * @OA\Schema(description="Статья", required={"id", "name"}, @OA\Xml(name="AuthorResponse"))
 *
 *
 * @mixin Eloquent
 */
class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(["name" => "mixed", "email" => "mixed"])] public function toArray($request): array
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
        ];
    }
}
