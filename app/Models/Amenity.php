<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    /** @use HasFactory<\Database\Factories\AmenityFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'icon',
    ];

    function properties(): BelongsToMany {
        return $this->belongsToMany(Property::class, 'property_amenity', 'amenity_id', 'property_id')
            ->using(PropertyAmenity::class);
            // ->withTimestamps();
    }
}
