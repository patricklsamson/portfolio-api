<?php

namespace App\Repositories\Message;

interface MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $includes
     * @param ?array $filterTypes
     * @param ?array $ids
     *
     * @return mixed
     */
    public function getAll(
        array $includes = [],
        ?array $filterTypes = null,
        ?array $ids = null
    );

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return mixed
     */
    public function getOne(string $id, array $includes = []);

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(string $id, array $attributes);

    /**
     * Delete model
     *
     * @param array $ids
     *
     * @return mixed
     */
    public function delete(array $ids);
}
