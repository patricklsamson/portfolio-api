<?php

namespace Tests;

class AssetTest extends BaseTest
{
    /**
     * GET /assets
     *
     * @return void
     */
    public function testShouldReturnAllAssets(): void
    {
        $this->get($this->ver . '/assets', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * GET /assets/categories
     *
     * @return void
     */
    public function testShouldReturnAllAssetCategories(): void
    {
        $this->get($this->ver . '/assets/categories', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * GET /assets/{id}
     *
     * @return void
     */
    public function testShouldReturnOneAsset(): void
    {
        $this->get($this->ver . '/assets/1', $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * POST /assets
     *
     * @return void
     */
    public function testShouldCreateAsset(): void
    {
        $this->post($this->ver . '/assets', [
            'data' => []
        ], $this->headers());

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * PUT /assets/{id}
     *
     * @return void
     */
    public function testShouldUpdateAsset(): void
    {
        $this->put($this->ver . '/assets/1', [
            'data' => []
        ], $this->headers());

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }

    /**
     * DELETE /assets/{id}
     *
     * @return void
     */
    public function testShouldDeleteAsset(): void
    {
        $this->delete($this->ver . '/assets/1', [], $this->headers());
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => []
        ]);
    }
}
