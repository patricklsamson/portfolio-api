<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @param LoginRequest $request
     *
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        return $this->authService->login($request);
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
