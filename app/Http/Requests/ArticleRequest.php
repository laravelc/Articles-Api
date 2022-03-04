<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Статья
 *
 * @OA\Schema(description="Запрос создание статьи", required={"categories",  "authors"},  schema="ArticleRequest",
 *         @OA\Property(
 *             property="title", type="string", example="", description="Заголовок"
 *         ),
 *         @OA\Property(
 *             property="source", type="string", example="", description="Откуда взята статья"
 *         ),
 *         @OA\Property(
 *             property="description", type="string", example="", description="Описание"
 *         ),
 *         @OA\Property(
 *             property="url", type="string", example="", description="url"
 *         ),
 *         @OA\Property(
 *             property="image_url", type="string", example="", description="Связанная картинка"
 *         ),
 *          @OA\Property(
 *              property="published_at", type="date", example="2021-10-31T09:15:57.572+03:00",
 *              description="Дата публикации в формате Y-m-d\TH:i:s.uP", nullable=true
 *          ),
 *         @OA\Property(
 *             property="content", type="string", example="", description="Контент"
 *         ),
 *         @OA\Property(
 *             property="type_name", type="string", example="", description="Тип"
 *         ),
 *          @OA\Property(
 *              property="authors",
 *              description="Авторы статьи статьи",
 *              type="array",
 *              @OA\Items(ref="#/components/schemas/Author")
 *          ),
 *          @OA\Property(
 *              property="categories",
 *              description="Категории",
 *              type="array",
 *              @OA\Items(ref="#/components/schemas/Category")
 *          )
 * )
 */
class ArticleRequest extends FormRequest
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
            'title' => 'required|string', //Должно быть поле и оно заполнено
            'source' => 'required|string',
            'description' => 'required|string',
            'url' => 'required|string',
            'image_url' => 'required|string',
            'published_at' => 'present|date_format:Y-m-d\TH:i:s.uP',//Поле должно быть но не обязательно заполнено
            'content' => 'required|string',
            'type_name' => 'filled|string|max:50',//Обязательно заполнено данными только если оно пристутсвует
            'authors' => 'required|array',
            'authors.*' => 'required|array',
            'authors.*.name' => 'required|string',
            'authors.*.email' => 'required|string|email',
            'categories' => 'required|array',
            'categories.*' => 'required|array',
            'categories.*.name' => 'required|string',
        ];
    }
}
