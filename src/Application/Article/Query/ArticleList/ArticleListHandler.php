<?php


namespace App\Application\Article\Query\ArticleList;


use App\Domain\Repositories\Article\ArticleRepository;

class ArticleListHandler extends AbstractQueryHandler
{
    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ArticleListQuery $query)
    {
        $articles = $this->repository->all();
        return new ArticleListQueryResponse($articles);
    }
}
