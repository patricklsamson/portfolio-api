<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Asset extends Model
{
    use HasFactory;

    /**
     * Enum attribute
     *
     * @var array
     */
    const TYPES = [
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'type', 'metadata'];

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
     * Scope query
     *
     * @param Builder $query
     * @param string $type
     *
     * @return Builder
     */
    public function scopeWhereType(Builder $query, string $type): Builder
    {
        return $type ?? $query->where('type', $type);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param string $order
     *
     * @return Builder
     */
    public function scopeSortStartDate(Builder $query, string $order = 'DESC'): Builder
    {
        return $query->orderBy('metadata->project->dates->start', $order);
    }
}
