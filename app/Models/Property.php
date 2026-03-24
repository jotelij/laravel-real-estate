<?php

namespace App\Models;

use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'agent_id',
        'title',
        'slug',
        'description',
        'property_type',
        'listing_type',
        'status',
        'price',
        'bedrooms',
        'bathrooms',
        'garages',
        'floor_area',
        'land_area',
        'year_built',
        'is_featured',
        'views_count',
        'virtual_tour_link',
    ];

    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'property_type' => PropertyType::class,
            'listing_type' => ListingType::class,
            'status' => PropertyStatus::class,
            'price'    => 'decimal:2',
        ];
    }

    /**
     * Get the agent that owns the property.
     */
    public function agent(): BelongsTo {
        return $this->belongsTo(AgentProfile::class, 'agent_id');
    }

    /**
     * Get the address associated with the property.
     */
    public function address(): HasOne {
        return $this->hasOne(PropertyAddress::class, 'property_id');    
    }

    /**
     * Get the images associated with the property.
     */
    public function images(): HasMany {
        return $this->hasMany(PropertyImage::class, 'property_id'); 
    }

    /**
    * Get the amenities associated with the property.
    */
    public function amenities(): BelongsToMany {
        return $this->belongsToMany(Amenity::class, 'property_amenity', 'property_id', 'amenity_id')
            ->using(PropertyAmenity::class);
            // ->withTimestamps();
    }

    /**
    * Get the enquiries associated with the property.
    */
    public function enquiries(): HasMany {
        return $this->hasMany(Enquiry::class, 'property_id');
    }

    /**
    * Get the viewings associated with the property.
    */
    public function viewings(): HasMany {
        return $this->hasMany(Viewing::class, 'property_id');
    }

    /**
    * Get the users who favourited the property.
    */
    public function favourited_users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'favourites', 'property_id', 'user_id')
            ->using(Favourite::class);
            // ->withTimestamps();
    }
}
