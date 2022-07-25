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
     * @param GetUserRequest $request
     *
     * @return JsonResource
     */
    public function profile(GetUserRequest $request): JsonResource
    {
        return $this->userService->profile($request);
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param GetUserRequest $request
     *
     * @return JsonResource
     */
    public function getOne(string $id, GetUserRequest $request): JsonResource
    {
        return $this->userService->getOne($id, $request);
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
     * Delete model
     *
     * @return Response
     */
    public function delete(): Response
    {
        return $this->userService->delete();
    }
}
