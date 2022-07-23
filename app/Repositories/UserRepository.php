<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Constructor
     *
     * @param User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Get all models
     *
     * @param ?array $includes
     * @param ?array $sorts
     *
     * @return ?Collection
     */
    public function getAll(
        ?array $includes = null,
        ?array $sorts = null
    ): ?Collection {
        return $this->model
            ->include($includes)
            ->sort($sorts)
            ->get();
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param ?array $includes
     *
     * @return ?User
     */
    public function getOne(string $id, ?array $includes = null): ?User
    {
        return $this->model->include($includes)->find($id);
    }
}
