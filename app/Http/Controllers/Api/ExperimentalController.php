<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExperimentalController extends Controller
{
    /**
     * Код проверки
     * @param Request $request
     * @return void
     */
    public function withPhotoInValidation(Request $request)
    {
        $data = [
            'photos' => [
                [
                    'name' => 'dssd',
                    'description' => 'description',
                ],
                [
                    'name' => 'weew',
                    'description' => 'description22',
                ]
            ],
        ];

        /**
         * Будет отображать позицию в массиве где выскочиала ошибка
         */
        $validator = Validator::make($data, [
            'photos.*.name' => 'required|string',
            'photos.*.description' => 'required|string',
        ],
            [
                'photos.*description.required' => 'Please provide a description for photo #:position',
            ]
        );
    }

    /**
     * whereNot
     * @param Request $request
     * @return void
     */
    public function eloquent(Request $request)
    {
        return User::query()->whereNot(fn($query) => $query->where('id', 10)->where('email', 'my@gmail.com'))->get();
    }


    /**
     * Работа с ключами подмассивов массива
     * @param Request $request
     * @return void
     */
    public function arrays_keys(Request $request)
    {
        $users = [
            ['name' => 'Taylor', 'active' => 0],
            ['name' => 'David'],
        ];

        /**
         * Заполняем если не заполнено
         */
        data_fill($data, '*.name', 'Maxim');

        /**
         * Устанавливаем новые значения
         */
        data_set($data, '*. name', 'Maxim');

        /**
         * Получаем массив ключей
         */
        data_get($data, '*. name');
    }

}
