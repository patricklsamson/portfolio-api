<?php

namespace App\Services;

use App\Exceptions\Address\NotFoundException;
use App\Repositories\User\UserRepository;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ResourceTrait;
    use ResponseTrait;

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
        $users = $this->userRepository->getAll(Arr::get($data, 'include'));
        throw_if(!$users->count(), NotFoundException::class);

        return $this->resource($users);
    }

    /**
     * Profile
     *
     * @param array $data
     *
     * @return mixed
     */
    public function profile(array $data)
    {
        return $this->resource($this->userRepository->getOne(
            auth()->user()->id,
            Arr::get($data, 'include')
        ));
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

        return $this->resource($user);
    }

    /**
     * Create model
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data) {
        Arr::set($data, 'data.attributes.password', Hash::make(
            Arr::get($data, 'data.attributes.password')
        ));

        unset($data['data']['attributes']['password_confirmation']);

        return $this->resource(
            $this->userRepository->create(Arr::get($data, 'data.attributes'))
        );
    }

    /**
     * Update model
     *
     * @param array $data
     *
     * @return mixed
     */
    public function update(array $data)
    {
        $id = auth()->user()->id;
        $this->userRepository->update($id, Arr::get($data, 'data.attributes'));

        return $this->resource($this->userRepository->getOne($id));
    }

    /**
     * Delete model
     *
     * @return mixed
     */
    public function delete()
    {
        $this->userRepository->delete(auth()->user()->id);

        return response($this->content(['success' => true]));
    }
}
