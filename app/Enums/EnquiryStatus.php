<?php

namespace App\Enums;

enum EnquiryStatus: int
{
    case NEW = 1;
    case IN_PROGRESS = 2;
    case RESOLVED = 3;

    public function label(): string
    {
        return match ($this) {
            static::NEW => 'New',
            static::IN_PROGRESS => 'In Progress',
            static::RESOLVED => 'Resolved',
        };
    }

    
     public function badgeClass(): string
    {
        return match($this) {
            self::NEW        => 'bg-blue-100 text-blue-800',
            self::IN_PROGRESS       => 'bg-yellow-100 text-yellow-800',
            self::RESOLVED    => 'bg-green-100 text-green-800',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}