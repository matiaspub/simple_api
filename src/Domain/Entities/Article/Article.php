<?php


namespace App\Domain\Entities\Article;


class Article
{
    /**
     * @var ArticleId
     */
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;

    // TODO @matiaspub timestamps

    public function __construct(string $title, string $description)
    {
        $this->id = new ArticleId();
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return ArticleId
     */
    public function getId(): ArticleId
    {
        return $this->id;
    }
}
