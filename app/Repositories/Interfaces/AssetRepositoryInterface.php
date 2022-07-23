<?php

namespace App\Repositories\Interfaces;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;

interface AssetRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $filterTypes
     * @param ?array $includes
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $includes = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object;

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?Asset
     */
    public function getOne(string $id, ?array $includes = null): ?Asset;
}
