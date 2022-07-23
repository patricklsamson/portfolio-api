<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $ids
     *
     * @return Builder
     */
    public function scopeWhereIdIn(Builder $query, ?array $ids = null): Builder
    {
        return $ids ? $query->whereIn('id', $ids) : $query;
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $includes
     *
     * @return Builder
     */
    public function scopeInclude(Builder $query, ?array $includes): Builder
    {
        return $includes ? $query->with($includes) : $query;
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?int $pageSize
     * @param ?int $pageNumber
     *
     * @return mixed
     */
    public function scopePage(
        Builder $query,
        ?int $pageSize = null,
        ?int $pageNumber = null,
        ?string $pageCursor = null,
        bool $isCursor = false
    ) {
        if ($pageSize) {
            return $isCursor || $pageCursor ? $query->cursorPaginate(
                $pageSize,
                ['*'],
                'page[cursor]',
                $pageCursor
            ) : $query->paginate($pageSize, ['*'], 'page[number]', $pageNumber);
        }

        if (!$pageSize && $query->get()->count() > 10) {
            return $isCursor || $pageCursor ? $query->cursorPaginate(
                10,
                ['*'],
                'page[cursor]',
                $pageCursor
            ) : $query->paginate(10, ['*'], 'page[number]', $pageNumber);
        }

        return $query->get();
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $sorts
     *
     * @return Builder
     */
    public function scopeSort(Builder $query, ?array $sorts = null): Builder
    {
        return $query->when($sorts, function ($query) use ($sorts) {
            foreach (array_chunk($sorts, 2) as $sort) {
                $query->orderBy(...$sort);
            }
        });
    }
}
