<?php

namespace App\Enums;

enum ViewingsStatus: int
{   
    case REQUESTED = 1;
    case CONFIRMED = 2;
    case COMPLETED = 3;
    case CANCELLED = 4 ;

    public function label(): string
    {
        return match($this) {
            self::REQUESTED => 'Requested',
            self::CONFIRMED => 'confirmed',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::REQUESTED        => 'bg-blue-100 text-blue-800',
            self::CONFIRMED       => 'bg-green-100 text-green-800',
            self::COMPLETED    => 'bg-muted-100 text-muted-800',
            self::CANCELLED    => 'bg-red-100 text-red-800',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}