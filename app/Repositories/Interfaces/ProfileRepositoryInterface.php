<?php

namespace App\Repositories\Interfaces;

interface ProfileRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $filterCategory
     * @param ?array $filterLevel
     * @param ?array $filterStarred
     * @param ?array $filterRole
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param bool $isCursor
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterCategory = null,
        ?array $filterLevel = null,
        ?array $filterStarred = null,
        ?array $filterRole = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        bool $isCursor = false,
        ?string $pageCursor = null
    ): ?object;
}
