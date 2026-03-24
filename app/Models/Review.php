<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'agent_id',
        'reviewer_id',
        'viewing_id',
        'rating',
        'comment',
        'is_approved',
    ];

    /**
     * Get the agent associated with the review.
     */
    public function agent(): BelongsTo {
        return $this->belongsTo(AgentProfile::class, 'agent_id');
    }

    /**
     * Get the reviewer associated with the review.
     */
    public function reviewer(): BelongsTo {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the viewing associated with the review.
     */
    public function viewing(): BelongsTo {
        return $this->belongsTo(Viewing::class, 'viewing_id');
    }
}
