<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    /**
     * Auth service
     *
     * @var AuthService
     */
    private $authService;

    /**
     * Constructor
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login
     *
     * @param LoginRequest $request
     *
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->data($request));
    }

    /**
     * Refresh token
     *
     * @return mixed
     */
    public function refresh()
    {
        return $this->authService->refresh();
    }

    /**
     * Logout
     *
     * @return mixed
     */
    public function logout()
    {
        return $this->authService->logout();
    }
}
