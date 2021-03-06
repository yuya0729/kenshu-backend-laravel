<?php

namespace App\Services;

use App\Entities\ArticleEntity;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Repositories\ArticleRepositoryInterface;
use Exception;

class ArticleService
{
    protected ArticleRepositoryInterface $articleRepositoryInterface;

    public function __construct(
        ArticleRepositoryInterface $articleRepositoryInterface
    )
    {
        $this->articleRepositoryInterface = $articleRepositoryInterface;
    }

    /**
     * @return ArticleEntity[]
     */
    public function findAll(): array
    {
        return $this->articleRepositoryInterface->findAll();
    }

    public function create(
        int    $user_id,
        string $title,
        string $body,
        array  $resources,
        string $thumbnail_resource,
        array  $tags
    )
    {
        return $this->articleRepositoryInterface->create(
            $user_id,
            $title,
            $body,
            $resources,
            $thumbnail_resource,
            $tags
        );
    }

    public function findById(int $id): ?ArticleEntity
    {
        return $this->articleRepositoryInterface->findById($id);
    }

    public function update(
        int    $id,
        string $title,
        string $body,
        array  $resources,
        string $thumbnail_resource,
        array  $tags,
        int    $user_id
    ): bool
    {
        $article = $this->articleRepositoryInterface->findById($id);
        if (!$article) {
            throw new NotFoundException();
        }
        if ($user_id !== $article->user->id) {
            throw new ForbiddenException('他のユーザーの投稿は、編集、更新、削除できません');
        }
        $is_update_success = $this->articleRepositoryInterface->update(
            $id,
            $title,
            $body,
            $resources,
            $thumbnail_resource,
            $tags
        );
        if (!$is_update_success) {
            throw new Exception();
        }
        return true;
    }

    public function destroy(int $id, int $user_id): bool
    {
        $article = $this->articleRepositoryInterface->findById($id);
        if (!$article) {
            throw new NotFoundException();
        }
        if ($user_id !== $article->user->id) {
            throw new ForbiddenException('他のユーザーの投稿は、編集、更新、削除できません');
        }
        $is_deleted_success = $this->articleRepositoryInterface->destroy($id);
        if (!$is_deleted_success) {
            throw new Exception();
        }
        return true;
    }
}
