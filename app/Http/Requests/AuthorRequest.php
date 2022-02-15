<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Статья
 *
 * @OA\Schema(description="Запрос на планирование отправки статьи", required={}, @OA\Xml(name="AuthorRequest"),
 *   @OA\Property(
 *          property="authors",
 *          description="Авторы статьи",
 *          type="array",
 *          @OA\Items(
 *              ref="#/components/schemas/Author")
 * ))
 **/
class AuthorRequest extends FormRequest
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
    public function rules(): array
    {
        return [
        ];
    }

}
