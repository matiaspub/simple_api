<?php


namespace App\Application\Article\Query\ArticleList;


use App\Domain\Entities\Article\Article;

class ArticleListQueryResponse
{
    /**
     * ArticleQueryResponse constructor.
     * @param array|Article[] $articles
     */
    public function __construct(array $articles)
    {
        // filter out some fields
    }
}
