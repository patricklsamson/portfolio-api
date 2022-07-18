<?php

namespace App\Repositories\Message;

use App\Models\Message;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $include
     * @param ?array $filterType
     * @param ?string $sortCreatedAt
     * @param ?array $ids
     *
     * @return mixed
     */
    public function getAll(
        array $includes = [],
        ?array $filterType = null,
        ?string $sortCreatedAt = null,
        ?array $ids = null
    ) {
        return Message::with($includes)
            ->whereIdIn($ids)
            ->filterType($filterType)
            ->sortCreatedAt($sortCreatedAt)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $includes
     *
     * @return mixed
     */
    public function getOne(string $id, array $includes = [])
    {
        return Message::with($includes)->find($id);
    }

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(string $id, array $attributes)
    {
        return Message::where('id', $id)->update($attributes);
    }

    /**
     * Delete model
     *
     * @param array $ids
     */
    public function delete(array $ids) {
        Message::destroy($ids);
    }
}
