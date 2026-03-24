<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Favourite extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'property_id',
    ];
}
