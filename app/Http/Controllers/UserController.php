<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Model service
     *
     * @var UserService
     */
    private $userService;

    /**
     * Constructor
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get all models
     *
     * @param GetUserRequest $request
     *
     * @return ResourceCollection
     */
    public function getAll(GetUserRequest $request): ResourceCollection
    {
        return $this->userService->getAll($request);
    }

    /**
     * Profile
     *
     * @return JsonResource
     */
    public function profile(): JsonResource
    {
        return $this->userService->profile();
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
        return $this->userService->getOne($id);
    }

    /**
     * Create model
     *
     * @param CreateUserRequest $request
     *
     * @return JsonResource
     */
    public function create(CreateUserRequest $request): JsonResource
    {
        return $this->userService->create($request);
    }

    /**
     * Update model
     *
     * @param UpdateUserRequest $request
     *
     * @return JsonResource
     */
    public function update(UpdateUserRequest $request): JsonResource
    {
        return $this->userService->update($request);
    }

    /**
     * Delete model/s
     *
     * @return Response
     */
    public function delete(): Response
    {
        return $this->userService->delete();
    }
}
