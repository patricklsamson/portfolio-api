<?php

namespace App\Services;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Arr;

class UserService
{
    /**
     * Model repository
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Constructor
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all models
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getAll(array $data)
    {
        return $this->userRepository->getAll(
            Arr::get($data, 'include'),
            Arr::get($data, 'sort.created_at')
        );
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param array $data
     *
     * @return mixed
     */
    public function getOne(string $id, array $data)
    {
        $user = $this->userRepository->getOne($id, Arr::get($data, 'include'));
        throw_if(!$user, NotFoundException::class);

        return $user;
    }

    /**
     * Create model
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data) {
        return $this->userRepository->create(Arr::get($data, 'data.attributes'));
    }

    /**
     * Update model
     *
     * @param string $id
     * @param array $data
     *
     * @return mixed
     */
    public function update(string $id, array $data)
    {
        $user = $this->userRepository->getOne($id);
        throw_if(!$user, NotFoundException::class);
        $this->userRepository->update($id, Arr::get($data, 'data.attributes'));

        return $this->userRepository->getOne($id);
    }
}
