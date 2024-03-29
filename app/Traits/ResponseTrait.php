<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ResponseTrait
{
    /**
     * Build content
     *
     * @param array $attributes
     *
     * @return array
     */
    public function content(array $attributes): array
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
    public function groupContent(array $group, array $attributes): array
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
     * @param string $token
     *
     * @return array
     */
    public function tokenContent(string $token): array
    {
        return $this->content([
            'token' => $token,
            'category' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 * 1000
        ]);
    }

    /**
     * Map purged ids
     *
     * @param array $ids
     *
     * @return array
     */
    public function purgedIdsMap(array $ids): array
    {
        $purgedIds = [];

        foreach ($ids as $id) {
            array_push($purgedIds, ['id' => $id]);
        }

        return $purgedIds;
    }
}
