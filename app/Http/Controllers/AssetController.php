<?php

namespace App\Http\Controllers;

use App\Http\Requests\Asset\CreateAssetRequest;
use App\Http\Requests\Asset\GetAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Http\Requests\Message\DeleteMessageRequest;
use App\Services\AssetService;

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
     * @return mixed
     */
    public function getAll(GetAssetRequest $request)
    {
        return $this->assetService->getAll($request->data($request));
    }

    /**
     * Get types
     *
     * @return mixed
     */
    public function getTypes()
    {
        return $this->assetService->getTypes();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param GetAssetRequest $request
     *
     * @return mixed
     */
    public function getOne(string $id, GetAssetRequest $request)
    {
        return $this->assetService->getOne($id, $request->data($request));
    }

    /**
     * Create model
     *
     * @param CreateAssetRequest $request
     *
     * @return mixed
     */
    public function create(CreateAssetRequest $request)
    {
        return $this->assetService->create($request->data($request));
    }

    /**
     * Update model
     *
     * @param string $id
     * @param UpdateAssetRequest $request
     *
     * @return mixed
     */
    public function update(string $id, UpdateAssetRequest $request)
    {
        return $this->assetService->update($id, $request->data($request));
    }

    /**
     * Delete model
     *
     * @param string $id
     * @param DeleteMessageRequest $request
     *
     * @return mixed
     */
    public function delete(string $id, DeleteMessageRequest $request)
    {
        return $this->assetService->delete($id, $request->data($request));
    }
}
