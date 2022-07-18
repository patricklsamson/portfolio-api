<?php

namespace App\Http\Controllers\Traits;

use App\Traits\ResourceTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait TokenTrait
{
    use ResourceTrait;

    /**
     * Token response
     *
     * @param string $token
     * @param ?string $include
     *
     * @return mixed
     */
    protected function respondWithToken(string $token, ?string $include = null)
    {
        $response = [
            'data' => [
                'attributes' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * Config::get('auth.expires_in')
                ]
            ]
        ];

        if ($include == 'user') {
            Arr::set($response, 'data.relationships.user', $this->relationships(auth()->user()));
            $response = array_merge($response, $this->include(auth()->user()));
        }

        return response($response, 200);
    }

    /**
     * Set included attribute
     *
     * @param mixed $user
     *
     * @return array
     */
    public function include($user): array
    {
        return ['included' => [$this->resource($user)]];
    }

    /**
     * Set relationships attribute
     *
     * @param mixed $user
     *
     * @return array
     */
    public function relationships($user): array
    {
        return [
            'data' => array_merge($this->resource($user)->only('id'), ['type' => 'users'])
        ];
    }
}
