<?php

namespace Tests;

class MessageTest extends BaseTest
{
    /**
     * GET /messages
     *
     * @return void
     */
    public function testShouldReturnAllMessages(): void
    {
        $this->get($this->ver . '/messages', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * GET /messages/categories
     *
     * @return void
     */
    public function testShouldReturnAllMessageCategories(): void
    {
        $this->get($this->ver . '/messages/categories', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * GET /messages/{id}
     *
     * @return void
     */
    public function testShouldReturnOneMessage(): void
    {
        $this->get($this->ver . '/messages/1', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * POST /messages
     *
     * @return void
     */
    public function testShouldCreateMessage(): void
    {
        $this->post($this->ver . '/messages', [
            'data' => []
        ], []);

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * PUT /messages/{id}
     *
     * @return void
     */
    public function testShouldUpdateMessage(): void
    {
        $this->put($this->ver . '/messages/1', [
            'data' => []
        ], $this->headers());

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * DELETE /messages/{id}
     *
     * @return void
     */
    public function testShouldDeleteMessage(): void
    {
        $this->delete($this->ver . '/messages/1', [], $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }
}
