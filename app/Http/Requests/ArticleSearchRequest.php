<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Статья
 *
 * @OA\Schema(description="Запрос поиск статьи", required={"category",  "authors"},  schema="ArticleSearchRequest",
 *         @OA\Property(
 *             property="type_name", type="string", example="", description="Тип"
 *         ),
 *         @OA\Property(
 *             property="q", type="string", example="", description="Текст"
 *         ),
 *          @OA\Property(
 *              property="from_date", type="date", example="2021-10-31T09:15:57.572+03:00",
 *              description="Поиск от даты в формате Y-m-d\TH:i:s.uP", nullable=true
 *          ),
 *          @OA\Property(
 *              property="to_date", type="date", example="2021-10-31T09:15:57.572+03:00",
 *              description="Поиск до даты в формате Y-m-d\TH:i:s.uP", nullable=true
 *          )
 * )
 */
class ArticleSearchRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['type_name' => "string", 'q' => "string", 'from_date' => "string", 'to_date' => "string"])] public function rules(): array
    {
        return [
            'type_name' => 'required|string',
            'q' => 'required|string',
            'from_date' => 'date_format:Y-m-d\TH:i:s.uP',
            'to_date' => 'date_format:Y-m-d\TH:i:s.uP',
        ];
    }
}
