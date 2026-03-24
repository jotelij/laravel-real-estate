<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentProfile extends Model
{
        /** @use HasFactory<\Database\Factories\AgentProfileFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'agency_name',
        'license_number',
        'bio',
        'est',
        'is_approved',   // this should be activated by admin
        'average_rating',
    ];

    /**
     * Get the user that owns the agent profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the properties listed by the agent.
     */
    public function properties()    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    /**
     * Get the enquiries reviews recieved by the users.
     */
    public function reviews(): HasMany {
        return $this->hasMany(Review::class, 'agent_id');
    }
}
