<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Response;

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
     *
     * @param AuthService $authService
     *
     * @return void
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
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        return $this->authService->login($request->data($request));
    }

    /**
     * Refresh token
     *
     * @return Response
     */
    public function refresh(): Response
    {
        return $this->authService->refresh();
    }

    /**
     * Logout
     *
     * @return Response
     */
    public function logout(): Response
    {
        return $this->authService->logout();
    }
}
