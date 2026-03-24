<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedSearch extends Model
{
    /** @use HasFactory<\Database\Factories\SavedSearchFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'filters',
        'last_modified_at',
    ];

    /**
     * Get the user associated with the saved search.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
