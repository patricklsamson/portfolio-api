<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object;
}
