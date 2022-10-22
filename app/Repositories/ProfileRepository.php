<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends BaseRepository implements
    ProfileRepositoryInterface
{
    /**
     * Constructor
     *
     * @param Profile $profile
     *
     * @return void
     */
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
    }

    /**
     * Get all models
     *
     * @param ?array $filterCategory
     * @param ?array $filterLevel
     * @param ?array $filterStarred
     * @param ?array $filterRole
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
        ?array $filterLevel = null,
        ?array $filterStarred = null,
        ?array $filterRole = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        bool $isCursor = false,
        ?string $pageCursor = null
    ): ?object {
        return $this->model
            ->byOwner()
            ->filterCategory($filterCategory)
            ->filterLevel($filterLevel)
            ->filterStarred($filterStarred)
            ->filterRole($filterRole)
            ->sort($sorts)
            ->page($pageSize, $pageNumber, $isCursor, $pageCursor);
    }
}
