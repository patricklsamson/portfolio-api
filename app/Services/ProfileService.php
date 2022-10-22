<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Profile\DeleteProfileRequest;
use App\Http\Requests\Profile\GetProfileRequest;
use App\Models\Profile;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProfileService extends BaseService
{
    use ResourceTrait;
    use ResponseTrait;

    /**
     * Get all models
     *
     * @param GetProfileRequest $request
     *
     * @return ResourceCollection
     */
    public function getAll(GetProfileRequest $request): ResourceCollection
    {
        $data = $request->data($request);

        $profiles = $this->profileRepository->getAll(
            Arr::get($data, 'filter.category'),
            Arr::get($data, 'filter.level'),
            Arr::get($data, 'filter.starred'),
            Arr::get($data, 'filter.role'),
            Arr::get($data, 'sort'),
            Arr::get($data, 'page.size'),
            Arr::get($data, 'page.number'),
            Arr::get($data, 'cursor', false),
            Arr::get($data, 'page.cursor')
        );

        throw_if(!$profiles->count(), NotFoundException::class);

        return $this->resource($profiles);
    }

    /**
     * Get levels
     *
     * @return Response
     */
    public function getLevels(): Response
    {
        return response(
            $this->groupContent(Profile::LEVELS, ['name', 'level'])
        );
    }

    /**
     * Delete model/s
     *
     * @param string $id
     * @param DeleteProfileRequest $request
     *
     * @return Response
     */
    public function delete(string $id, DeleteProfileRequest $request): Response
    {
        $ids = Arr::get($request->data($request), 'include');
        $ids[] = $id;
        $ids = array_unique($ids, SORT_REGULAR);

        throw_if(
            !$this->profileRepository->getAllByIdIn($ids),
            NotFoundException::class
        );

        $this->profileRepository->delete($ids);

        return response($this->content([
            'success' => true,
            'purged' => $this->purgedIdsMap($ids)
        ]));
    }
}
