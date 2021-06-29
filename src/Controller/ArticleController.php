<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\ArticleRepositoryInterface;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class ArticleController extends Controller
{
    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List of articles
     *
     * @Rest\Get("/article")
     * @OA\Parameter(
     *     name="sort",
     *     in="query",
     *     description="The field used to order articles",
     *     @OA\Schema(type="string", default="id")
     * )
     * @OA\Parameter(
     *     name="order",
     *     in="query",
     *     description="The value of order direction",
     *     @OA\Schema(type="string", default="asc")
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Limits select to a set of items",
     *     @OA\Schema(type="int")
     * )
     * @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     description="Starts select from a setted position",
     *     @OA\Schema(type="int")
     * )
     * @OA\Response(
     *     response="200",
     *     description="",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=Article::class))
     *     )
     * )
     */
    public function index(Request $request): Response
    {
        try {
            $articles = $this->repository->findBy(
                [],
                [$request->get('sort', 'id') => $request->get('order', 'asc')],
                $request->get('limit'),
                $request->get('offset')
            );
            return $this->response($articles);
        } catch (Exception $e) {
            return $this->response('Not found', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Detail information of article
     *
     * @Rest\Get("/article/{id}")
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Article identifier",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response="200",
     *     description="",
     *     @OA\JsonContent(ref=@Model(type=Article::class))
     * )
     * @OA\Response(
     *     response="404",
     *     description="Not found"
     * )
     */
    public function detail(Article $article): Response
    {
        return $this->response($article);
    }

    /**
     * Creating a new article
     *
     * @Rest\Post("/article")
     * @OA\Post(
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="article",
     *                  type="object",
     *                  @OA\Property(
     *                      property="title",
     *                      description="Article title",
     *                      example="An article"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Article description",
     *                      example="An article description"
     *                  ),
     *              )
     *          )
     *     )
     * )
     * @OA\Response(
     *     response="200",
     *     description="",
     *     @OA\JsonContent(ref=@Model(type=Article::class))
     * )
     * @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="code", example="400", type="int"),
     *          @OA\Property(property="message", example="Validation Failed", type="string"),
     *          @OA\Property(property="errors", type="object"),
     *     )
     * )
     * @Security(name="api_key")
     */
    public function store(Request $request): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->response($form, Response::HTTP_BAD_REQUEST);
        }

        $article = $form->getData();
        $this->repository->save($article);

        return $this->response($article);
    }

    /**
     * Updating an existing article
     *
     * @Rest\Post("/article/{id}")
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Article identifier",
     *     @OA\Schema(type="string")
     * )
     * @OA\Post(
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="article",
     *                  type="object",
     *                  @OA\Property(
     *                      property="title",
     *                      description="Article title",
     *                      example="An article"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Article description",
     *                      example="An article description"
     *                  ),
     *              )
     *          )
     *     )
     * )
     * @OA\Response(
     *     response="200",
     *     description="",
     *     @OA\JsonContent(ref=@Model(type=Article::class))
     * )
     * @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="code", example="400", type="int"),
     *          @OA\Property(property="message", example="Validation Failed", type="string"),
     *          @OA\Property(property="errors", type="object"),
     *     )
     * )
     * @OA\Response(
     *     response="404",
     *     description="Not found"
     * )
     * @Security(name="api_key")
     */
    public function update(Article $article, Request $request): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->response($form, Response::HTTP_BAD_REQUEST);
        }

        $this->repository->save($article);

        return $this->response($article);
    }

    /**
     * Deleting an article
     *
     * @Rest\Delete("/article/{id}")
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Article identifier",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response="200",
     *     description=""
     * )
     * @OA\Response(
     *     response="404",
     *     description="Not found"
     * )
     * @Security(name="api_key")
     */
    public function delete(Article $article): Response
    {
        $this->repository->remove($article);
        return $this->response('');
    }
}
