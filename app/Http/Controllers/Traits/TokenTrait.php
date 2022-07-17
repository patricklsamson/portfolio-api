<?php

namespace App\Http\Controllers\Traits;

use App\Traits\ResourceTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait TokenTrait
{
    use ResourceTrait;

    /**
     * Token response
     *
     * @param mixed $token
     */
    protected function respondWithToken($token)
    {
        return response([
            'data' => [
                'attributes' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * Config::get('auth.expires_in')
                ]
            ]
        ], 200);
    }
}
