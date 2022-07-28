<?php

namespace App\Repositories\Interfaces;

interface ProfileRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $filterTypes
     * @param ?array $filterLevels
     * @param ?array $filterStarreds
     * @param ?array $filterRoles
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $filterLevels = null,
        ?array $filterStarreds = null,
        ?array $filterRoles = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object;
}
