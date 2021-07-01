<?php


namespace App\Domain\Repositories\Article;


use App\Domain\Entities\Article\Article;

interface ArticleRepository
{
    /**
     * @param array|Article[]|Article $articles
     * @return mixed
     */
    public function save($articles);

    /**
     * @param array|Article[]|Article $articles
     * @return mixed
     */
    public function remove($articles);

    /**
     * @param string $id
     * @return mixed
     */
    public function oneById(string $id): ?Article;

    /**
     * @return array
     */
    public function all(): array;
}
