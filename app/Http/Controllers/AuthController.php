<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Traits\TokenTrait;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use TokenTrait;

    /**
     * Login
     *
     * @param LoginRequest $request
     *
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        throw_if(
            !$token = Auth::attempt($request->data($request)['data']['attributes']),
            UnauthorizedException::class
        );

        return $this->respondWithToken($token);
    }

    /**
     * Logout
     *
     * @return mixed
     */
    public function logout()
    {
        auth()->logout();

        return response([
            'data' => [
                'attributes' => [
                    'logout' => 'success'
                ]
            ]
        ], 200);
    }
}
