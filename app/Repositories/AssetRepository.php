<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\AssetRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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
     * @param ?array $includes
     * @param ?array $filterTypes
     *
     * @return ?Collection
     */
    public function getAll(
        ?array $includes = null,
        ?array $filterTypes = null
    ): ?Collection {
        return $this->model
            ->filterTypes($filterTypes)
            ->include($includes)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?Asset
     */
    public function getOne(string $id, ?array $includes = null): ?Asset
    {
        return $this->model->include($includes)->find($id);
    }
}
