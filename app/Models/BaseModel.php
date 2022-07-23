<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
