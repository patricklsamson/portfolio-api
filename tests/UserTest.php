<?php

namespace Tests;

class UserTest extends BaseTest
{
    /**
     * GET /users
     *
     * @return void
     */
    public function testShouldReturnAllUsers(): void
    {
        $this->get($this->ver . '/users', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * GET /users/profile
     *
     * @return void
     */
    public function testShouldReturnProfile(): void
    {
        $this->get($this->ver . '/users/profile', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * GET /users/{id}
     *
     * @return void
     */
    public function testShouldReturnOneUser(): void
    {
        $this->get($this->ver . '/users/1', []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * POST /users
     *
     * @return void
     */
    public function testShouldCreateUser(): void
    {
        $this->post($this->ver . '/users', [
            'data' => []
        ], []);

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * PUT /users/profile
     *
     * @return void
     */
    public function testShouldUpdateProfile(): void
    {
        $this->put($this->ver . '/users/profile', [
            'data' => []
        ], $this->headers());

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * DELETE /users/terminate
     *
     * @return void
     */
    public function testShouldDeleteUser(): void
    {
        $this->delete($this->ver . '/users/terminate', [], $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }
}
