<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait ResponseTrait
{
    /**
     * Build content
     *
     * @param array $attributes
     *
     * @return array
     */
    public function buildContent(array $attributes): array
    {
        return [
            'data' => [
                'attributes' => $attributes
            ]
        ];
    }

    /**
     * Build group content
     *
     * @param array $group
     * @param array $attributes
     *
     * @return array
     */
    public function buildGroupContent(array $group, array $attributes): array
    {
        $content = [];

        foreach ($group as $key => $value) {
            $content['data'][] = is_numeric($key) ? [
                'id' => $value,
                'attributes' => [$attributes[0] => $value]
            ] : [
                'id' => $key,
                'attributes' => array_combine($attributes, [$key, $value])
            ];
        }

        return $content;
    }

    /**
     * Build token content
     *
     * @param mixed $token
     *
     * @return mixed
     */
    public function buildTokenContent($token)
    {
        return $this->buildContent([
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() *
                Config::get('auth.expires_in')
        ]);
    }
}
