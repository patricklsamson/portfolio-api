<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends BaseModel
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
     * Enum attribute
     *
     * @var array
     */
    const LEVELS = [
        'beginner' => 1,
        'advanced' => 2,
        'competent' => 3,
        'proficient' => 4,
        'expert' => 5
    ];

    /**
     * Resource attributes
     *
     * @var array
     */
    const ATTRIBUTES = [
        'description',
        'level',
        'starred',
        'start_date',
        'end_date',
        'metadata'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'level',
        'starred',
        'start_date',
        'end_date',
        'metadata',
        'user_id',
        'achievement_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'metadata' => 'array'
    ];

    /**
     * Get parent model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get parent model
     *
     * @return BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeByOwner(Builder $query): Builder
    {
        return $query->where('user_id', auth()->user()->id);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $types
     *
     * @return Builder
     */
    public function scopeFilterTypes(
        Builder $query,
        ?array $types = null
    ): Builder {
        return $types ? $query->whereIn('type', $types) : $query;
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $levels
     *
     * @return Builder
     */
    public function scopeFilterLevels(
        Builder $query,
        ?array $levels = null
    ): Builder {
        return $levels ? $query->whereIn('level', $levels) : $query;
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $starred
     *
     * @return Builder
     */
    public function scopeFilterStarreds(
        Builder $query,
        ?array $starreds = null
    ): Builder {
        return $starreds == null ? $query : $query->whereIn(
            'starred',
            $starreds
        );
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $roles
     *
     * @return Builder
     */
    public function scopeFilterRoles(
        Builder $query,
        ?array $roles = null
    ): Builder {
        return $roles ? $query->whereIn(
            'metadata->project->role',
            $roles
        ) : $query;
    }
}
