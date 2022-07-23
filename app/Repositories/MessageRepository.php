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
     * @param ?array $filterTypes
     * @param ?array $includes
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return mixed
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $includes = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ) {
        return $this->model
            ->filterTypes($filterTypes)
            ->include($includes)
            ->sort($sorts)
            ->page($pageSize, $pageNumber, $pageCursor);
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
