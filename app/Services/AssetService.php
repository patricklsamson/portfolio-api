<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\DeleteAssetRequest;
use App\Http\Requests\Asset\GetAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Models\Asset;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class AssetService extends BaseService
{
    use ResourceTrait;
    use ResponseTrait;

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
        $data = $request->data($request);
        $asset = $this->assetRepository->create(
            Arr::get($request->data($request), 'data.attributes')
        );

        if (Arr::has($data, 'data.relationships.address')) {
            $address = 'data.relationships.address.data.attributes';
            $type = get_class($this->assetRepository->model);

            Arr::set($data, "$address.parentable_id", $asset->id);
            Arr::set($data, "$address.parentable_type", $type);

            $this->addressRepository->updateOrCreate(
                ['parentable_id' => $asset->id, 'parentable_type' => $type],
                Arr::get($data, $address)
            );
        }

        return $this->resource($asset);
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

        $data = $request->data($request);

        $this->assetRepository->update($id, Arr::get($data, 'data.attributes'));

        if (Arr::has($data, 'data.relationships.address')) {
            $address = 'data.relationships.address.data.attributes';
            $type = get_class($this->assetRepository->model);

            Arr::set($data, "$address.parentable_id", $id);
            Arr::set($data, "$address.parentable_type", $type);

            $this->addressRepository->updateOrCreate(
                ['parentable_id' => $id, 'parentable_type' => $type],
                Arr::get($data, $address)
            );
        }

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
