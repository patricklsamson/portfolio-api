<?php

namespace App\Services;

use App\Exceptions\Address\NotFoundException;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
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
     * Repository service
     *
     * @var RepositoryService
     */
    private $repositoryService;

    /**
     * Constructor
     *
     * @param RepositoryService $repositoryService
     *
     * @return void
     */
    public function __construct(RepositoryService $repositoryService)
    {
        $this->repositoryService = $repositoryService;
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

        $users = $this->repositoryService->userRepository->getAll(
            Arr::get($data, 'sort'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'cursor', false),
            Arr::get($data, 'page.cursor')
        );

        return $this->resource($users);
    }

    /**
     * Profile
     *
     * @return JsonResource
     */
    public function profile(): JsonResource
    {
        return $this->resource($this->repositoryService->userRepository->getOne(
            auth()->user()->id
        ));
    }

    /**
     * Get one model
     *
     * @param string $id
     *
     * @return JsonResource
     */
    public function getOne(string $id): JsonResource
    {
        $user = $this->repositoryService->userRepository->getOne($id);

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

        return $this->resource($this->repositoryService->userRepository->create(
            Arr::get($data, 'data.attributes')
        ));
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

        $this->repositoryService->userRepository->update($id, Arr::get(
            $data,
            'data.attributes',
            []
        ));

        if (Arr::has($data, 'data.relationships.address')) {
            $address = 'data.relationships.address.data.attributes';
            $type = get_class($this->repositoryService->userRepository->model);

            Arr::set($data, "$address.parentable_id", $id);
            Arr::set($data, "$address.parentable_type", $type);

            $this->repositoryService->addressRepository->updateOrCreate(
                ['parentable_id' => $id, 'parentable_type' => $type],
                Arr::get($data, $address)
            );
        }

        return $this->resource(
            $this->repositoryService->userRepository->getOne($id)
        );
    }

    /**
     * Delete model/s
     *
     * @return Response
     */
    public function delete(): Response
    {
        $this->repositoryService->userRepository->delete(auth()->user()->id);

        return response($this->content(['success' => true]));
    }
}
