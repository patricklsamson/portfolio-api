<?php

namespace App\Repositories\Message;

use App\Models\Message;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Get all models
     *
     * @param array $request
     *
     * @return mixed
     */
    public function getAll(array $request)
    {
        return Message::with($request['include'])
            ->whereType($request['filter']['type'])
            ->sortCreatedAt($request['sort']['created_at'])
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $request
     *
     * @return mixed
     */
    public function getOne(string $id, array $request)
    {
        return Message::with($request['include'])->find($id);
    }

    /**
     * Create model
     *
     * @param array $request
     *
     * @return mixed
     */
    public function create(array $request)
    {
        return Message::create($request['data']['attributes']);
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $request
     *
     * @return mixed
     */
    public function updateType(string $id, array $request)
    {
        Message::where('id', $id)->update($request['data']['attributes']);

        return Message::find($id);
    }

    /**
     * Delete model
     *
     * @param string $id
     *
     * @return void
     */
    public function delete(string $id) {
        Message::destroy($id);
    }
}
