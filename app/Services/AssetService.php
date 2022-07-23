<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Asset;
use App\Repositories\AssetRepository;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
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
     * @return ResourceCollection
     */
    public function getAll(array $data): ResourceCollection
    {
        $assets = $this->assetRepository->getAll(
            Arr::get($data, 'filter.type'),
            Arr::get($data, 'include'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'page.cursor')
        );

        throw_if(!$assets, NotFoundException::class);

        return $this->resource($assets);
    }

    /**
     * Get types
     *
     * @return Response
     */
    public function getTypes(): Response
    {
        return response($this->groupContent(Asset::TYPES, ['name']));
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $data
     *
     * @return JsonResource
     */
    public function getOne(string $id, array $data): JsonResource
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
     *
     * @return JsonResource
     */
    public function create(array $data): JsonResource
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
     *
     * @return JsonResource
     */
    public function update(string $id, array $data): JsonResource
    {
        $assetId = $this->assetRepository->update($id, Arr::get($data, 'data.attributes'));
        throw_if(!$assetId, NotFoundException::class);

        return $this->resource($this->assetRepository->getOne($assetId));
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param array $data
     *
     * @return Response
     */
    public function delete(string $id, array $data): Response
    {
        $ids = Arr::get($data, 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);

        throw_if(!$this->assetRepository->get, NotFoundException::class);
        $assetIds = $this->assetRepository->delete(
            array_unique($ids, SORT_REGULAR)
        );


        return response($this->content(['success' => true]));
    }
}
