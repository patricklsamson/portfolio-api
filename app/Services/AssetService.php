<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Asset;
use App\Repositories\Asset\AssetRepository;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

class AssetService
{
    use ResourceTrait;
    use ResponseTrait;

    /**
     * Asset repository
     *
     * @var AssetRepository
     */
    private $assetRepository;

    /**
     * Constructor
     *
     * @param AssetRepository $assetRepository
     */
    public function __construct(AssetRepository $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    /**
     * Get all models
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getAll(array $data)
    {
        $assets = $this->assetRepository->getAll(
            Arr::get($data, 'include'),
            Arr::get($data, 'filter.type')
        );

        throw_if(!$assets, NotFoundException::class);

        return $this->resource($assets);
    }

    /**
     * Get types
     *
     * @return mixed
     */
    public function getTypes()
    {
        return response($this->groupContent(Asset::TYPES, ['name']));
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $data
     *
     * @return mixed
     */
    public function getOne(string $id, array $data)
    {
        $asset = $this->assetRepository
            ->getOne($id, Arr::get($data, 'include'));

        throw_if(!$asset, NotFoundException::class);

        return $this->resource($asset);
    }

    /**
     * Create model
     *
     * @param array $data
     */
    public function create(array $data)
    {
        return $this->resource(
            $this->assetRepository->create(Arr::get($data, 'data.attributes'))
        );
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $data
     */
    public function update(string $id, array $data)
    {
        $asset = $this->assetRepository->getOne($id);
        throw_if(!$asset, NotFoundException::class);
        $this->assetRepository->update($id, Arr::get($data, 'data.attributes'));

        return $this->resource($this->assetRepository->getOne($id));
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param array $data
     */
    public function delete(string $id, array $data)
    {
        $ids = Arr::get($data, 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);
        $assets = $this->assetRepository->getAll([], null, null, $ids);
        throw_if(!$assets, NotFoundException::class);
        $this->assetRepository->delete($ids);

        return response($this->content(['success' => true]));
    }
}
