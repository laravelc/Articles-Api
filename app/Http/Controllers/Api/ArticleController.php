<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\ArticleSearchRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Поиск
     * @OA\Get(
     * path="/api/articles/search",
     * summary="Поиск статей",
     * description="Поиск статей",
     * operationId="articleList",
     * tags={"article"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *         description="Поля",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ArticleSearchRequest")
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#Article"))
     *  )
     * )
     * @param ArticleSearchRequest $request
     * @return AnonymousResourceCollection
     */
    public function search(ArticleSearchRequest $request): AnonymousResourceCollection
    {
        /** @var Article $query */
        $query = Article::with(['categories', 'author']);

        if ($request->has('type_name')) {
            $query->searchText($request->input('type_name'));
        }

        if ($request->has('q')) {
            $query->searchText($request->input('q'));
        }

        if ($request->has('from_date')) {
            $query->fromDate(Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $request->input('from_date')));
        }

        if ($request->has('to_date')) {
            $query->toDate(Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $request->input('to_date')));
        }

        $articles = $query->paginate(15);

        return ArticleResource::collection($articles);
    }

    /**
     *
     * Сохранить
     *
     * @param ArticleRequest $request
     * @return ArticleResource
     * @OA\Post(
     *     path="/api/article",
     *     operationId="store",
     *     tags={"Articles"},
     *     summary="Создание статьи",
     *     @OA\RequestBody(
     *         description="Поля",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ArticleRequest")
     *     ),
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
     *         description="Доступ в api запрещен или приложение не найдено",
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
     *     @OA\Response(response=422, description="Ошибка валидации."),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     * )
     * )
     * @throws AuthorizationException
     */
    public function store(ArticleRequest $request): ArticleResource
    {
        $this->authorizeKeyable('article', new Article());
        $this->authorizeKeyable('author', new Author());

        /** @var Article $article */
        $article = Article::create($request->all());
        $article->authors()->attach(Author::getOrCreate($request->get('authors')));
        $article->categories()->attach(Category::getOrCreate($request->get('categories')));
        $article->load('authors', 'categories');

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param int $articleId
     * @return ArticleResource
     * @throws AuthorizationException
     * @OA\Get(
     *     path="/api/article/{id}",
     *     operationId="show",
     *     tags={"Articles"},
     *     summary="Получение статьи",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID статьи",
     *         required=true,
     *         in="path",
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
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
     *         description="Доступ в api запрещен или приложение не найдено",
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
     *     @OA\Response(response=422, description="Ошибка валидации."),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *     )
     * )
     */
    public function show(int $articleId): ArticleResource
    {
        $this->authorizeKeyable('article', new Article());
        $this->authorizeKeyable('author', new Author());

        /** @var Article $article */
        $article = Article::find($articleId);

        if (!$article) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $article->load('authors', 'categories');

        return new ArticleResource($article);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param int $articleId
     * @return ArticleResource
     * @throws AuthorizationException
     * @OA\Patch(
     *     path="/api/article/{id}",
     *     operationId="update",
     *     tags={"Articles"},
     *     summary="Обновить статьи",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID статьи",
     *         required=true,
     *         in="path",
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Поля",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ArticleRequest")
     *     ),
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
     *     @OA\Response(response=422, description="Ошибка валидации."),
     *     @OA\Response(
     *         response=403,
     *         description="Доступ в api запрещен или приложение не найдено",
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
     *         response=200,
     *         description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *     )
     * )
     */
    public function update(ArticleRequest $request, int $articleId): ArticleResource
    {
        $this->authorizeKeyable('article', new Article());
        $this->authorizeKeyable('author', new Author());

        /** @var Article $article */
        $article = Article::find($articleId);

        if (!$article) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $article->update((array)$request);
        $article->categories()->sync(Category::getOrCreate($request->get('categories')));
        $article->authors()->sync(Author::getOrCreate($request->get('authors')));
        $article->load('authors', 'categories');

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $articleId
     * @return ArticleResource
     * @throws AuthorizationException
     * @OA\Delete(
     *     path="/api/article/{id}",
     *     operationId="destroy",
     *     tags={"Articles"},
     *     summary="Удаление статьи",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID статьи",
     *         required=true,
     *         in="path",
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *     )
     * )
     */
    public function destroy(int $articleId): ArticleResource
    {
        $this->authorizeKeyable('article', new Article());
        $this->authorizeKeyable('author', new Author());

        /** @var Article $article */
        $article = Article::find($articleId);

        if (!$article) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $article->categories()->detach();
        $article->authors()->detach();
        $article->delete();

        return new ArticleResource($article);
    }


}
