<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyAmenity extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'property_id',
        'amenity_id'
    ];
}
