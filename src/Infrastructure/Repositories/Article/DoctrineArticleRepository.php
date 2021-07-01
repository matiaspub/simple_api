<?php


namespace App\Infrastructure\Repositories\Article;


use App\Domain\Entities\Article\Article;
use App\Domain\Repositories\Article\ArticleRepository;
use Doctrine\ORM\EntityManager;

class DoctrineArticleRepository implements ArticleRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    private $repository;
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Article::class);
    }

    /**
     * @inheritDoc
     */
    public function save($articles)
    {
        if (!is_array($articles)) {
            $articles = [$articles];
        }

        $toFlush = [];
        foreach ($articles as $article) {
            // TODO @matiaspub check instanceof
            $this->em->persist($article);
            $toFlush[] = $article;
        }

        $this->em->flush($toFlush);
    }

    /**
     * @inheritDoc
     */
    public function remove($articles)
    {
        if (!is_array($articles)) {
            $articles = [$articles];
        }

        $toFlush = [];
        foreach ($articles as $article) {
            // TODO @matiaspub check instanceof
            $this->em->remove($article);
            $toFlush[] = $article;
        }

        $this->em->flush($toFlush);
    }

    /**
     * @inheritDoc
     */
    public function oneById(string $id): ?Article
    {
        // TODO: Implement oneById() method.
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        // TODO: Implement all() method.
    }
}
