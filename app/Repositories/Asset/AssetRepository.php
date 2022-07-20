<?php

namespace App\Repositories\Asset;

use App\Models\Asset;

class AssetRepository implements AssetRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     * @param ?array $filterTypes
     *
     * @return mixed
     */
    public function getAll(
        array $includes = [],
        ?array $filterTypes = null,
        ?array $ids = null
    ) {
        return Asset::with($includes)
            ->whereIdIn($ids)
            ->filterTypes($filterTypes)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return mixed
     */
    public function getOne(string $id, array $includes = [])
    {
        return Asset::with($includes)->find($id);
    }

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Asset::create($attributes);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(string $id, array $attributes)
    {
        return Asset::where('id', $id)->update($attributes);
    }

    /**
     * Delete model/s
     *
     * @param array $ids
     *
     * @return mixed
     */
    public function delete(array $ids)
    {
        return Asset::destroy($ids);
    }
}
