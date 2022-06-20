<?php

namespace App\Services;

use App\Entities\ArticleEntity;
use App\Exceptions\NotFoundException;
use App\Repositories\ArticleRepositoryInterface;

class ArticleService
{
    protected ArticleRepositoryInterface $articleRepositoryInterface;

    public function __construct(ArticleRepositoryInterface $articleRepositoryInterface)
    {
        $this->articleRepositoryInterface = $articleRepositoryInterface;
    }

    public function create(
        int    $user_id,
        string $title,
        string $body,
    )
    {
        return $this->articleRepositoryInterface->create(
            $user_id,
            $title,
            $body,
        );
    }

    public function findById(int $id): ?ArticleEntity
    {
        return $this->articleRepositoryInterface->findById($id);
    }

    public function update(int $id, string $title, string $body): bool
    {
        $article = $this->articleRepositoryInterface->findById($id);
        if (!$article) {
            throw new NotFoundException();
        }
        $this->articleRepositoryInterface->update($id, $title, $body);
        return true;
    }
}
