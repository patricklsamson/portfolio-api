<?php

namespace App\Repositories\Interfaces;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;

interface AssetRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $includes
     * @param ?array $filterTypes
     *
     * @return ?Collection
     */
    public function getAll(
        ?array $includes = null,
        ?array $filterTypes = null
    ): ?Collection;

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
