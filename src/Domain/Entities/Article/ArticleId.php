<?php


namespace App\Domain\Entities\Article;


use Ramsey\Uuid\Uuid;

class ArticleId
{
    public function __construct()
    {
        $this->value = Uuid::uuid4()->toString();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $value): bool
    {
        return (string) $this === (string) $value;
    }
}
