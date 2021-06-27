<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @inheritDoc
     */
    public function save(Article $article): void
    {
        $this->getEntityManager()->persist($article);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove(Article $article): void
    {
        $this->getEntityManager()->remove($article);
        $this->getEntityManager()->flush();
    }
}
