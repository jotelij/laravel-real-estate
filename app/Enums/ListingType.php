<?php

namespace App\Enums;

enum ListingType: int
{
    case SELL = 1;
    case RENT = 2;

    public function label(): string
    {
        return match($this) {
            self::SELL => 'Sell',
            self::RENT => 'Rent',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::SELL => 'bg-blue-100 text-blue-800',
            self::RENT => 'bg-green-100 text-green-800',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}