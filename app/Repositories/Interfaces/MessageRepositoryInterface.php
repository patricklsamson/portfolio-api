<?php

namespace App\Repositories\Interfaces;

use App\Models\Message;

interface MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $filterTypes
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object;
}
