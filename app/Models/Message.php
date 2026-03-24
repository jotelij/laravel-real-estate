<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enquiry_id',
        'sender_id',
        'body',
        'read_at'
    ];

    /**
     * Get the enquiry associated with the message.
     */
    public function enquiry(): BelongsTo {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');  
    }

    /**
     * Get the sender (user) of the message.
     */
    public function sender(): BelongsTo {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function markAsRead() {
        $this->read_at = now();
        $this->save();
    }
}
