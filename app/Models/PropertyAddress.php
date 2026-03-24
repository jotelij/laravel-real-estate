<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyAddress extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyAddressFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'property_id',
        'address_line_1',
        'address_line_2',
        'city',
        'region',
        'postcode',
        'country',
        'latitude',
        'longitude',  
    ];


    /**
     * Get the property that owns the address.
     */
    public function property(): BelongsTo {
        return $this->belongsTo(Property::class, 'property_id');    
    }

    public function full_address(): string {
        return implode(', ', array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->region,
            $this->postcode,
            $this->country
        ]));
    }
}
