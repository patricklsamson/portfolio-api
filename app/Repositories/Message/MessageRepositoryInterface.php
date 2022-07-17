<?php

namespace App\Repositories\Message;

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

    /**
     * Create model
     *
     * @param array $request
     *
     * @return mixed
     */
    public function create(array $request);

    /**
     * Update model
     *
     * @param string $id
     * @param array $request
     *
     * @return mixed
     */
    public function updateType(string $id, array $request);

    /**
     * Delete model
     *
     * @param string $id
     *
     * @return void
     */
    public function delete(string $id);
}
