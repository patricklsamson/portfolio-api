<?php

namespace Tests;

class ProfileTest extends BaseTest
{
    /**
     * GET /profiles
     *
     * @return void
     */
    public function testShouldReturnAllProfiles(): void
    {
        $this->get($this->ver . '/profiles', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * DELETE /profiles/{id}
     *
     * @return void
     */
    public function testShouldDeleteProfile(): void
    {
        $this->delete($this->ver . '/profiles/1', [], $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }
}
