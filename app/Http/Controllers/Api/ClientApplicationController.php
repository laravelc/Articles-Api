<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientApplicationResource;
use App\Models\ClientApplication;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

class ClientApplicationController extends Controller
{
    /**
     * @param Request $request
     * @return ClientApplicationResource
     * @throws AuthorizationException
     * @OA\Get(
     *     path="/api/client_application",
     *     operationId="show",
     *     tags={"Разное"},
     *     summary="Получить информацию о текущем приложении (через передаваемый api ключ)",
     *     description="Возращает документ в json",
     *     @OA\Response(
     *         response=401,
     *         description="Не переданы данные авторизации",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="success",
     *                         type="boolean",
     *                         description="Успешный ли запрос",
     *                         example=false
     *                     ),
     *                     @OA\Property(
     *                         property="error",
     *                         type="string",
     *                         description="Сообщение об ошибке",
     *                         example="Доступ запрещен"
     *                     ),
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Доступ в Api запрещен или приложение не найдено",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="success",
     *                         type="boolean",
     *                         description="Успешный ли запрос",
     *                         example=false
     *                     ),
     *                     @OA\Property(
     *                         property="error",
     *                         type="string",
     *                         description="Сообщение об ошибке",
     *                         example="Доступ запрещен"
     *                     ),
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="success",
     *                         type="boolean",
     *                         description="Успешный ли запрос",
     *                         example=true
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         description="The response data",
     *                         ref="#/components/schemas/ClientApplication",
     *                     ),
     *                 )
     *             )
     *         }
     *     ),
     * )
     */
    public function show(Request $request): ClientApplicationResource
    {
        $this->authorizeKeyable('view', new ClientApplication());

        $apiApp = $request->keyable;
        if (!$apiApp) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $this->authorizeKeyable('view', $apiApp);

        return new ClientApplicationResource($apiApp);
    }
}
