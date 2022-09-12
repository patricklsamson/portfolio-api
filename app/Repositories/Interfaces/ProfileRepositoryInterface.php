<?php

namespace App\Repositories\Interfaces;

interface ProfileRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $filterCategories
     * @param ?array $filterLevels
     * @param ?array $filterStarreds
     * @param ?array $filterRoles
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param bool $isCursor
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterCategories = null,
        ?array $filterLevels = null,
        ?array $filterStarreds = null,
        ?array $filterRoles = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        bool $isCursor = false,
        ?string $pageCursor = null
    ): ?object;
}
