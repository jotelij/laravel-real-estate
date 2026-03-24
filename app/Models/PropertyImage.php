<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyImageFactory> */
    use HasFactory;
    
        /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'property_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    /**
    * Get the property that owns the image.
    */
    public function property(): BelongsTo {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
