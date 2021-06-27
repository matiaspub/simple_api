<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\ArticleRepositoryInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Rest\Get("/article")
     */
    public function index(Request $request): Response
    {
        $articles = $this->repository->findBy(
            [],
            [$request->get('sort', 'id') => $request->get('order', 'asc')],
            $request->get('limit'),
            $request->get('offset')
        );
        return $this->response($articles);
    }

    /**
     * @Rest\Get("/article/{id}")
     */
    public function detail(Article $article): Response
    {
        return $this->response($article);
    }

    /**
     * @Rest\Post("/article")
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
     * @Rest\Post("/article/{id}")
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
     * @Rest\Delete("/article/{id}")
     */
    public function delete(Article $article): Response
    {
        $this->repository->remove($article);
        return $this->response('');
    }

}
