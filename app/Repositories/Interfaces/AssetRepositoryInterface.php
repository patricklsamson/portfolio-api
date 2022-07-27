<?php

namespace App\Repositories\Interfaces;

use App\Models\Asset;

interface AssetRepositoryInterface
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
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object;
}
