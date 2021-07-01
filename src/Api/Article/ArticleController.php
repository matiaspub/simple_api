<?php


namespace App\Api\Article;


use App\Application\Article\Query\ArticleList\ArticleListHandler;
use App\Application\Article\Query\ArticleList\ArticleListQuery;

class ArticleController
{
    // TODO @matiaspub CRUD actions

    public function list(ArticleListQuery $query, ArticleListHandler $handler)
    {
        $handler->handle($query);
    }
}
