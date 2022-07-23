<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get all models
     *
     * @param ?array $includes
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return mixed
     */
    public function getAll(
        ?array $includes = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    );

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?User
     */
    public function getOne(string $id, ?array $includes = null): ?User;
}
