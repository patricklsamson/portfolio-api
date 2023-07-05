<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaseTest extends TestCase
{
    /**
     * API version prefix
     *
     * @var string
     */
    public $ver = "v1";

    /**
     * Create headers with auth token
     *
     * @param array $additionalHeaders
     *
     * @return array
     */
    public function headers(array $additionalHeaders = []): array
    {
        $token = Auth::fromUser($this->user());

        return array_merge([
            'Authorization' => "Bearer $token"
        ], $additionalHeaders);
    }

    /**
     * Create user factory
     *
     * @return User
     */
    public function user(): User
    {
        return User::factory()->create();
    }
}
