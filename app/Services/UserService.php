<?php

namespace App\Services;

use App\Exceptions\Address\NotFoundException;
use App\Repositories\UserRepository;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
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
     *
     * @return void
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
     * @return ResourceCollection
     */
    public function getAll(array $data): ResourceCollection
    {
        $users = $this->userRepository->getAll(
            Arr::get($data, 'include'),
            Arr::get($data, 'sort')
        );

        throw_if(!$users->count(), NotFoundException::class);

        return $this->resource($users);
    }

    /**
     * Profile
     *
     * @param array $data
     *
     * @return JsonResource
     */
    public function profile(array $data): JsonResource
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
     * @return JsonResource
     */
    public function getOne(string $id, array $data): JsonResource
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
     * @return JsonResource
     */
    public function create(array $data): JsonResource
    {
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
     * @return JsonResource
     */
    public function update(array $data): JsonResource
    {
        $id = auth()->user()->id;
        $this->userRepository->update($id, Arr::get($data, 'data.attributes'));

        return $this->resource($this->userRepository->getOne($id));
    }

    /**
     * Delete model
     *
     * @return Response
     */
    public function delete(): Response
    {
        $this->userRepository->delete(auth()->user()->id);

        return response($this->content(['success' => true]));
    }
}
