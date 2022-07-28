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
     * Model service
     *
     * @var ProfileService
     */
    private $profileService;

    /**
     * Constructor
     *
     * @param ProfileService $profileService
     *
     * @return void
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

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
