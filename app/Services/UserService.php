<?php

namespace App\Services;

use App\Exceptions\Address\NotFoundException;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\AddressRepository;
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
     * Associated model repository
     *
     * @var AddressRepository
     */
    private $addressRepository;

    /**
     * Constructor
     *
     * @param UserRepository $userRepository
     * @param AddressRepository $addressRepository
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        AddressRepository $addressRepository
    ) {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
    }

    /**
     * Get all models
     *
     * @param GetUserRequest $request
     *
     * @return ResourceCollection
     */
    public function getAll(GetUserRequest $request): ResourceCollection
    {
        $data = $request->data($request);

        $users = $this->userRepository->getAll(
            Arr::get($data, 'include'),
            Arr::get($data, 'sort'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'page.cursor')
        );

        throw_if(!$users->count(), NotFoundException::class);

        return $this->resource($users);
    }

    /**
     * Profile
     *
     * @param GetUserRequest $request
     *
     * @return JsonResource
     */
    public function profile(GetUserRequest $request): JsonResource
    {
        $data = $request->data($request);

        return $this->resource($this->userRepository->getOne(
            auth()->user()->id,
            Arr::get($data, 'include')
        ));
    }

    /**
     * Get one model
     *
     * @param string $id
     * @param GetUserRequest $request
     *
     * @return JsonResource
     */
    public function getOne(string $id, GetUserRequest $request): JsonResource
    {
        $user = $this->userRepository->getOne($id, Arr::get(
            $request->data($request),
            'include'
        ));

        throw_if(!$user, NotFoundException::class);

        return $this->resource($user);
    }

    /**
     * Create model
     *
     * @param CreateUserRequest $request
     *
     * @return JsonResource
     */
    public function create(CreateUserRequest $request): JsonResource
    {
        $data = $request->data($request);

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
     * @param UpdateUserRequest $request
     *
     * @return JsonResource
     */
    public function update(UpdateUserRequest $request): JsonResource
    {
        $data = $request->data($request);
        $id = auth()->user()->id;

        $this->userRepository->update($id, Arr::get($data, 'data.attributes'));

        if (Arr::has($data, 'data.relationships.address')) {
            $address = 'data.relationships.address.data.attributes';
            $type = get_class($this->userRepository->model);

            Arr::set($data, "$address.parentable_id", $id);
            Arr::set($data, "$address.parentable_type", $type);

            $this->addressRepository->updateOrCreate(
                ['parentable_id' => $id, 'parentable_type' => $type],
                Arr::get($data, 'data.relationships.address.data.attributes')
            );

            return $this->resource(
                $this->userRepository->getOne($id)
            );
        }

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
