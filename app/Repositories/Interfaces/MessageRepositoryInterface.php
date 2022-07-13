<?php

namespace App\Repositories\Interfaces;

interface MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $request
     *
     * @return mixed
     */
    public function getAll(array $request);

    /**
     * Get one model
     *
     * @param string $id
     * @param array $request
     *
     * @return mixed
     */
    public function getOne(string $id, array $request);
}
