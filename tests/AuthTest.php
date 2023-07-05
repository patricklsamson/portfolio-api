<?php

namespace Tests;

class AuthTest extends BaseTest
{
    /**
     * GET /auth/refresh
     *
     * @return void
     */
    public function testShouldRefreshToken(): void
    {
        $this->get($this->ver . '/auth/refresh', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * POST /login
     *
     * @return void
     */
    public function testShouldLogin(): void
    {
        $user = $this->user();

        $this->post($this->ver . '/auth/login', [
            'data' => [
                'attributes' => [
                    'username' => $user->username,
                    'password' => $user->password
                ]
            ]
        ]);

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * DELETE /logout
     *
     * @return void
     */
    public function testShouldLogout(): void
    {
        $this->delete($this->ver . '/auth/logout', [], $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }
}
