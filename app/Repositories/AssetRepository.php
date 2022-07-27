<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\AssetRepositoryInterface;

class AssetRepository extends BaseRepository implements AssetRepositoryInterface
{
    /**
     * Constructor
     *
     * @param Asset $asset
     *
     * @return void
     */
    public function __construct(Asset $asset)
    {
        parent::__construct($asset);
    }

    /**
     * Get all models
     *
     * @param ?array $filterTypes
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object {
        return $this->model
            ->filterTypes($filterTypes)
            ->get();
    }
}
