<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository extends BaseRepository implements
    MessageRepositoryInterface
{
    /**
     * Constructor
     *
     * @param Message $message
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        parent::__construct($message);
    }

    /**
     * Get all models
     *
     * @param ?array $includes
     * @param ?array $filterTypes
     * @param ?array $sorts
     *
     * @return ?Collection
     */
    public function getAll(
        ?array $includes = null,
        ?array $filterTypes = null,
        ?array $sorts = null
    ): ?Collection {
        return $this->model
            ->filterTypes($filterTypes)
            ->sort($sorts)
            ->include($includes)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?Message
     */
    public function getOne(string $id, ?array $includes = null): ?Message
    {
        return $this->model->include($includes)->find($id);
    }
}
