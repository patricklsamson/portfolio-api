<?php

namespace App\Repositories;

use App\Models\Asset;
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
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param bool $isCursor
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        bool $isCursor = false,
        ?string $pageCursor = null
    ): ?object {
        return $this->model
            ->filterTypes($filterTypes)
            ->sort($sorts)
            ->page($pageSize, $pageNumber, $isCursor, $pageCursor);
    }
}
