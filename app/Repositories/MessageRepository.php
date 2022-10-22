<?php

namespace App\Repositories;

use App\Models\Message;
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
     * @param ?array $filterCategory
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param bool $isCursor
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterCategory = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        bool $isCursor = false,
        ?string $pageCursor = null
    ): ?object {
        return $this->model
            ->byOwner()
            ->filterCategory($filterCategory)
            ->sort($sorts)
            ->page($pageSize, $pageNumber, $isCursor, $pageCursor);
    }
}
