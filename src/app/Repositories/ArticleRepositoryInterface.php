<?php

namespace App\Repositories;

use App\Entities\ArticleEntity;

interface ArticleRepositoryInterface
{
    /**
     * @return ArticleEntity[]
     */
    public function findAll(): array;

    public function create(
        int    $user_id,
        string $title,
        string $body,
        array  $resources,
        string $thumbnail_resource,
        array  $tags
    );

    public function findById(int $id): ?ArticleEntity;

    public function update(
        int    $id,
        string $title,
        string $body,
        array  $resources,
        string $thumbnail_resource,
        array  $tags
    ): bool;

    public function destroy(int $id): bool;
}
