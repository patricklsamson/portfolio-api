<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Traits\ResourceTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthService
{
    use ResourceTrait;

    /**
     * Login
     *
     * @param array $data
     *
     * @return mixed
     */
    public function login(array $data)
    {
        $token = Auth::attempt(Arr::get($data, 'data.attributes'));
        throw_if(!$token, UnauthorizedException::class);
        $response = $this->response($token);

        if (Arr::get($data, 'include') == 'user') {
            Arr::set($response, 'data.relationships.user.data', [
                'id' => auth()->user()['id'],
                'type' => 'users'
            ]);

            $response = array_merge($response, ['included' => [$this->resource(auth()->user())]]);
        }

        return response($response);
    }

    /**
     * Refresh token
     *
     * @return mixed
     */
    public function refresh()
    {
        $token = Auth::fromUser(auth()->user());
        Auth::invalidate();

        return response($this->response($token));
    }

    /**
     * Logout
     *
     * @return mixed
     */
    public function logout()
    {
        Auth::invalidate();
        auth()->logout();

        return response($this->response(null, ['success' => true]));
    }

    private function response(?string $token = null, ?array $attributes = null): array
    {
        return [
            'data' => [
                'attributes' => $token ? [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * Config::get('auth.expires_in')
                ] : $attributes
            ]
        ];
    }
}
