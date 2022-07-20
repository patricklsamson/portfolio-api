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
    protected $casts = ['metadata' => 'array'];

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
     * @param ?string $level
     *
     * @return Builder
     */
    public function scopeFilterLevel(
        Builder $query,
        ?string $level = null
    ): Builder {
        return $level ? $query->where('level', $level) : $query;
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?bool $starred
     *
     * @return Builder
     */
    public function scopeFilterStarred(
        Builder $query,
        ?bool $starred = false
    ): Builder {
        return $query->where('starred', $starred ? $starred : false);
    }

    /**
     * Scope query
     *
     * @param Builder $query
     * @param ?string $role
     *
     * @return Builder
     */
    public function scopeFilterRole(
        Builder $query,
        ?string $role = null
    ): Builder {
        return $role ? $query->where('metadata->project->role', $role) : $query;
    }
}
