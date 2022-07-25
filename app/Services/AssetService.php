<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\DeleteAssetRequest;
use App\Http\Requests\Asset\GetAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
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
     * @param GetAssetRequest $request
     *
     * @return ResourceCollection
     */
    public function getAll(GetAssetRequest $request): ResourceCollection
    {
        $data = $request->data($request);

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
     * @param GetAssetRequest $request
     *
     * @return JsonResource
     */
    public function getOne(string $id, GetAssetRequest $request): JsonResource
    {
        $asset = $this->assetRepository
            ->getOne($id, Arr::get($request->data($request), 'include'));

        throw_if(!$asset, NotFoundException::class);

        return $this->resource($asset);
    }

    /**
     * Create model
     *
     * @param CreateAssetRequest $request
     *
     * @return JsonResource
     */
    public function create(CreateAssetRequest $request): JsonResource
    {
        return $this->resource($this->assetRepository->create(
            Arr::get($request->data($request), 'data.attributes')
        ));
    }

    /**
     * Update model
     *
     * @param string $id
     * @param UpdateAssetRequest $request
     *
     * @return JsonResource
     */
    public function update(
        string $id,
        UpdateAssetRequest $request
    ): JsonResource {
        throw_if(
            !$asset = $this->assetRepository->getOne($id),
            NotFoundException::class
        );

        $this->assetRepository->update($id, Arr::get(
            $request->data($request),
            'data.attributes'
        ));

        return $this->resource($asset);
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param DeleteAssetRequest $request
     *
     * @return Response
     */
    public function delete(string $id, DeleteAssetRequest $request): Response
    {
        $ids = Arr::get($request->data($request), 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);

        throw_if(
            !$this->assetRepository->getAllByIdIn($ids),
            NotFoundException::class
        );

        $this->assetRepository->delete($ids);

        return response($this->content(['success' => true]));
    }
}
