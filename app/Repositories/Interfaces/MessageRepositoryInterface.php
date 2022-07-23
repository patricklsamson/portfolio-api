<?php

namespace App\Repositories\Interfaces;

use App\Models\Message;

interface MessageRepositoryInterface
{
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
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $includes = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object;

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?Message
     */
    public function getOne(string $id, ?array $includes = null): ?Message;
}
