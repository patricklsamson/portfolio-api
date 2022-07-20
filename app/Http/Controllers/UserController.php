<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;

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
     * @return mixed
     */
    public function getAll(GetUserRequest $request)
    {
        return $this->userService->getAll($request->data($request));
    }

    /**
     * Profile
     *
     * @param GetUserRequest $request
     *
     * @return mixed
     */
    public function profile(GetUserRequest $request)
    {
        return $this->userService->profile($request->data($request));
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param GetUserRequest $request
     *
     * @return mixed
     */
    public function getOne(string $id, GetUserRequest $request)
    {
        return $this->userService->getOne($id, $request->data($request));
    }

    /**
     * Create model
     *
     * @param CreateUserRequest $request
     *
     * @return mixed
     */
    public function create(CreateUserRequest $request) {
        return $this->userService->create($request->data($request));
    }

    /**
     * Update model
     *
     * @param UpdateUserRequest $request
     *
     * @return mixed
     */
    public function update(UpdateUserRequest $request)
    {
        return $this->userService->update($request->data($request));
    }

    /**
     * Delete model
     *
     * @return mixed
     */
    public function delete()
    {
        return $this->userService->delete();
    }
}
