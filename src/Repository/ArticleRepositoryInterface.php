<?php

namespace App\Repository;


use App\Entity\Article;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ArticleRepositoryInterface
{
    /**
     * @param Article $article
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Article $article): void;

    /**
     * @param Article $article
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Article $article);
}
