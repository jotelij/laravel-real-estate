<?php

namespace App\Models;

use App\Enums\EnquiryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enquiry extends Model
{
    /** @use HasFactory<\Database\Factories\EnquiryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'property_id',
        'sender_id',
        'agent_id',
        'subject',
        'message',
        'status'
    ];

    protected $casts = [
        'status' => EnquiryStatus::class,
    ];

    /**
     * Get the property associated with the enquiry.
     */
    public function property(): BelongsTo {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * Get the sender (user) of the enquiry.
     */
    public function sender(): BelongsTo {
        return $this->belongsTo(User::class, 'sender_id');  
    }

    /**
     * Get the agent (user) associated with the enquiry.
     */
    public function agent(): BelongsTo {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
    * Get the messages associated with the enquiry.
    */  
    public function messages(): HasMany {
        return $this->hasMany(Message::class, 'enquiry_id');    
    }
}
