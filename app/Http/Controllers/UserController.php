<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Services\UserService;
use App\Traits\ResourceTrait;

class UserController extends Controller
{
    use ResourceTrait;

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
        return $this->resource(
            $this->userService->getAll($request->data($request))
        );
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
        return $this->resource(
            $this->userService->getOne($id, $request->data($request))
        );
    }

    /**
     * Create model
     *
     * @param CreateUserRequest $request
     *
     * @return mixed
     */
    public function create(CreateUserRequest $request) {
        return $this->resource(
            $this->userService->create($request->data($request))
        );
    }
}
