<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\DeleteProfileRequest;
use App\Http\Requests\Profile\GetProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Get all models
     *
     * @param GetProfileRequest $request
     *
     * @return ResourceCollection
     */
    public function getAll(GetProfileRequest $request): ResourceCollection
    {
        return $this->profileService->getAll($request);
    }

    /**
     * Get levels
     *
     * @return Response
     */
    public function getLevels(): Response
    {
        return $this->profileService->getLevels();
    }

    /**
     * Delete model/s
     *
     * @param string $id
     * @param DeleteProfileRequest $request
     *
     * @return Response
     */
    public function delete(string $id, DeleteProfileRequest $request): Response
    {
        return $this->profileService->delete($id, $request);
    }
}
