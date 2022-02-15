<?php

namespace App\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class ClientApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['id' => "mixed", 'name' => "mixed", 'callback_url' => "mixed", 'created_at' => "mixed"])] public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'callback_url' => $this->callback_url,
            'created_at' => $this->created_at->format(DateTimeInterface::ISO8601),
        ];
    }
}
