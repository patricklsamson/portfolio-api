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
        'category',
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
        'category',
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

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?array $levels
     *
     * @return Builder
     */
    public function scopeFilterLevel(
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
    public function scopeFilterStarred(
        Builder $query,
        ?array $starred = null
    ): Builder {
        return $starred == null ? $query : $query->whereIn(
            'starred',
            $starred
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
    public function scopeFilterRole(
        Builder $query,
        ?array $roles = null
    ): Builder {
        return $roles ? $query->whereIn(
            'metadata->project->role',
            $roles
        ) : $query;
    }
}
