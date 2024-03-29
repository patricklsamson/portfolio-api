<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Asset extends BaseModel
{
    use HasFactory;

    /**
     * Enum attribute
     *
     * @var array
     */
    const CATEGORIES = [
        'education',
        'training',
        'certification',
        'experience',
        'affiliation',
        'project',
        'soft_skill',
        'tech_skill'
    ];

    /**
     * Resource attributes
     *
     * @var array
     */
    const ATTRIBUTES = ['name', 'slug', 'category', 'metadata'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'category', 'metadata'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['metadata' => 'array'];

    /**
     * Get associated models
     *
     * @return HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Get associated model
     *
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'parentable');
    }

    /**
     * Get associated models
     *
     * @return HasManyThrough
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Profile::class,
            'asset_id',
            'id',
            'id',
            'user_id'
        );
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $categories
     *
     * @return Builder
     */
    public function scopeFilterCategory(
        Builder $query,
        ?array $categories = null
    ): Builder {
        return $categories ? $query->whereIn('category', $categories) : $query;
    }
}
