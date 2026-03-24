<?php

namespace App\Models;


use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

       // Role check helpers
    public function hasRole(UserRole $role): bool
    {
        return $this->role->value === $role->value;
    }

    public function is_admin(): bool
    {
        return $this->hasRole(UserRole::ADMIN);
    }

    public function is_agent(): bool
    {
        return $this->hasRole(UserRole::AGENT);
    }

    public function is_customer(): bool
    {
        return $this->hasRole(UserRole::CUSTOMER);
    }

     /**
     * Get the agent profile associated with the user.
     */
    public function agent_profile(): HasOne
    {
        return $this->hasOne(AgentProfile::class);
    }

    /**
     * Get all of the properties listed by the user.
     */
    public function properties(): HasManyThrough
    {
        return $this->hasManyThrough(Property::class, AgentProfile::class, 'user_id', 'agent_id');
    }

    /**
    * Get the enquiries sent by the user.
    */
    public function enquiries_sent(): HasMany {
        return $this->hasMany(Enquiry::class, 'sender_id');
    }

    /**
     * Get the enquiries received by the user (as an agent).
     */
    public function enquiries_received(): HasMany {
        return $this->hasMany(Enquiry::class, 'agent_id');
    }

    /**
     * Get the reviews by the user.
     */
    public function reviews(): HasMany {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

     /**
     * Get the viewings by the user.
     */
    public function viewings(): HasMany {
        return $this->hasMany(Viewing::class, 'buyer_id');
    }

    /**
     * Get the viewings by the user (as an agent).
     */
    public function agent_viewings(): HasMany {
        return $this->hasMany(Viewing::class, 'agent_id');
    }

    /**
    * Get the favourite properties associated with the user.
    */
    public function favourites(): BelongsToMany {
        return $this->belongsToMany(Property::class, 'favourites', 'user_id', 'property_id')
            ->using(Favourite::class);
            // ->withTimestamps();
    }
}
