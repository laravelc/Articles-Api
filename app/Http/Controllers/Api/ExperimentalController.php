<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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


}
