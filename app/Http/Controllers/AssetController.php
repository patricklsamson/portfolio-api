<?php

namespace App\Http\Controllers;

use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\DeleteAssetRequest;
use App\Http\Requests\Asset\GetAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Services\AssetService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class AssetController extends Controller
{
    /**
     * Asset service
     *
     * @var AssetService
     */
    private $assetService;

    /**
     * Constructor
     *
     * @param AssetService $assetService
     */
    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
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
        return $this->assetService->getAll($request);
    }

    /**
     * Get types
     *
     * @return Response
     */
    public function getTypes(): Response
    {
        return $this->assetService->getTypes();
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
        return $this->assetService->getOne($id);
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
        return $this->assetService->create($request);
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
        return $this->assetService->update($id, $request);
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
        return $this->assetService->delete($id, $request);
    }
}
