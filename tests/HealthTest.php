<?php

namespace Tests;

class HealthTest extends BaseTest
{
    /**
     * GET /health
     *
     * @return void
     */
    public function testShouldCheckHealth(): void
    {
        $this->get($this->ver . '/health', []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                'attributes' => [
                    'name',
                    'version',
                    'status',
                    'framework'
                ]
            ]
        ]);
    }
}
