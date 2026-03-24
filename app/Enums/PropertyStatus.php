<?php

namespace App\Enums;

enum PropertyStatus: int
{
    case ACTIVE = 1;
    case PENDING = 2;
    case SOLD = 3; 
    case RENTED = 4;
    case OFF_MARKET = 5;
    case ARCHIVED = 6;

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::PENDING => 'Pending',
            self::SOLD => 'Sold',
            self::RENTED => 'Rented',
            self::OFF_MARKET => 'Off Market',
            self::ARCHIVED => 'Archived',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::ACTIVE        => 'bg-blue-100 text-blue-800',
            self::PENDING       => 'bg-pink-100 text-pink-800',
            self::SOLD    => 'bg-green-100 text-green-800',
            self::RENTED    => 'bg-green-100 text-green-800',
            self::OFF_MARKET => 'bg-muted text-muted-foreground',
            self::ARCHIVED => 'bg-muted text-muted-foreground',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}