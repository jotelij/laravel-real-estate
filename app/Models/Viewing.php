<?php

namespace App\Models;

use App\Enums\ViewingsStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Viewing extends Model
{
    /** @use HasFactory<\Database\Factories\ViewingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'property_id',
        'buyer_id',
        'agent_id',
        'scheduled_at',
        'status', // Status can be managed via a separate enum or constant in the future
        'notes'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'status' => ViewingsStatus::class,
    ];
    
    /**
     * Get the property associated with the viewing.
     */
    public function property(): BelongsTo {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * Get the buyer (user) associated with the viewing.
     */
    public function buyer(): BelongsTo {
        return $this->belongsTo(User::class, 'buyer_id');   
    }

    /**
     * Get the agent (user) associated with the viewing.
     */
    public function agent(): BelongsTo {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
