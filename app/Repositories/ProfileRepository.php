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
     * @param ?array $filterTypes
     * @param ?array $filterLevels
     * @param ?array $filterStarreds
     * @param ?array $filterRoles
     * @param ?array $sorts
     * @param ?int $pageSize
     * @param ?int $pageNumber
     * @param ?string $pageCursor
     *
     * @return ?object
     */
    public function getAll(
        ?array $filterTypes = null,
        ?array $filterLevels = null,
        ?array $filterStarreds = null,
        ?array $filterRoles = null,
        ?array $sorts = null,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null
    ): ?object {
        return $this->model
            ->byOwner()
            ->filterTypes($filterTypes)
            ->filterLevels($filterLevels)
            ->filterStarreds($filterStarreds)
            ->filterRoles($filterRoles)
            ->sort($sorts)
            ->page($pageSize, $pageNumber, $pageCursor);
    }
}
