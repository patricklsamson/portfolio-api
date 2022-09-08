<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\UnprocessableEntityException;
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

class AssetService
{
    use ResourceTrait;
    use ResponseTrait;

    /**
     * Repository service
     *
     * @var RepositoryService
     */
    private $repositoryService;

    /**
     * Constructor
     *
     * @param RepositoryService $repositoryService
     *
     * @return void
     */
    public function __construct(RepositoryService $repositoryService)
    {
        $this->repositoryService = $repositoryService;
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

        $assets = $this->repositoryService->assetRepository->getAll(
            Arr::get($data, 'filter.type'),
            Arr::get($data, 'sort'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'cursor', false),
            Arr::get($data, 'page.cursor')
        );

        throw_if(!$assets->count(), NotFoundException::class);

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
     *
     * @return JsonResource
     */
    public function getOne(string $id): JsonResource
    {
        $asset = $this->repositoryService->assetRepository->getOne($id);

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

        $asset = $this->repositoryService->assetRepository->create(
            Arr::get($data, 'data.attributes')
        );

        if (Arr::has($data, 'data.relationships.address')) {
            $address = 'data.relationships.address.data.attributes';
            $type = get_class($this->repositoryService->assetRepository->model);

            Arr::set($data, "$address.parentable_id", $asset->id);
            Arr::set($data, "$address.parentable_type", $type);

            $this->addressRepository->create(Arr::get($data, $address));
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
            !$this->repositoryService->assetRepository->getOne($id),
            NotFoundException::class
        );

        $data = $request->data($request);

        if (Arr::has($data, 'data.relationships.address')) {
            $address = 'data.relationships.address.data.attributes';
            $type = get_class($this->repositoryService->assetRepository->model);

            Arr::set($data, "$address.parentable_id", $id);
            Arr::set($data, "$address.parentable_type", $type);

            $this->addressRepository->updateOrCreate(
                ['parentable_id' => $id, 'parentable_type' => $type],
                Arr::get($data, $address)
            );
        }

        if (Arr::has($data, 'data.relationships.profiles')) {
            $profile = 'data.relationships.profiles.data.attributes';
            $userId = auth()->user()->id;

            Arr::set($data, "$profile.user_id", $userId);
            Arr::set($data, "$profile.asset_id", $id);

            $this->profileRepository->updateOrCreate(
                ['user_id' => $userId, 'asset_id', $id],
                Arr::get($data, $profile)
            );
        }

        return $this->resource(
            $this->repositoryService->assetRepository->update($id, Arr::get(
                $data,
                'data.attributes',
                []
            ))
        );
    }

    /**
     * Delete model/s
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
            !$this->repositoryService->assetRepository->getAllByIdIn($ids),
            NotFoundException::class
        );

        $this->repositoryService->assetRepository->delete($ids);

        return response($this->content(['success' => true]));
    }
}
