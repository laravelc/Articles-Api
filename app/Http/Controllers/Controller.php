<?php

namespace App\Http\Controllers;

use Givebutter\LaravelKeyable\Auth\AuthorizesKeyableRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base controller class
 *
 * @OA\Info(
 *      version="1.0.0",
 *      title="Articles",
 *      description="Сервис статей",
 *      @OA\Contact(
 *          email="av.pavlow@gmail.com"
 *      )
 * )
 * @OA\Tag(
 *     name="Статьи",
 *     description="Работа с статьими",
 * )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *  )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Api Server"
 * )
 *  @OA\Server(
 *      url="https://projects.dev/api/v1",
 *      description="L5 Swagger OpenApi Server"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesKeyableRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
