<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\MessageRepositoryInterface;

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
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object {
        return $this->model
            ->filterTypes($filterTypes)
            ->sort($sorts)
            ->page($pageSize, $pageNumber, $pageCursor);
    }
}
