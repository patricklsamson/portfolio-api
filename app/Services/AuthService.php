<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    use ResponseTrait;
    use ResourceTrait;

    /**
     * Login
     *
     * @param array $data
     *
     * @return Response
     */
    public function login(array $data): Response
    {
        $token = Auth::attempt(Arr::get($data, 'data.attributes'));
        throw_if(!$token, UnauthorizedException::class);
        $content = $this->tokenContent($token);

        if (Arr::get($data, 'include') == 'user') {
            Arr::set($content, 'data.relationships.user.data', [
                'id' => auth()->user()->id,
                'type' => 'users'
            ]);

            $content = array_merge($content, [
                'included' => [$this->resource(auth()->user())]
            ]);
        }

        return response($content);
    }

    /**
     * Refresh token
     *
     * @return Response
     */
    public function refresh(): Response
    {
        $token = Auth::fromUser(auth()->user());
        Auth::invalidate();

        return response($this->tokenContent($token));
    }

    /**
     * Logout
     *
     * @return Response
     */
    public function logout(): Response
    {
        Auth::invalidate();
        auth()->logout();

        return response($this->content(['success' => true]));
    }
}
