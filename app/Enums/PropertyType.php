<?php

namespace App\Enums;

enum PropertyType: int
{
    case HOUSE = 1;
    case APARTMENT = 2;
    case VILLA = 3;
    case COMMERCIAL = 4;
    case LAND = 5;
    case OTHER = 6;

    public function label(): string
    {
        return match($this) {
            self::HOUSE => 'House',
            self::APARTMENT => 'Apartment',
            self::VILLA => 'Villa',
            self::COMMERCIAL => 'Commercial',
            self::LAND => 'Land',
            self::OTHER => 'Other',
        };
    }

    
    public function badgeClass(): string
    {
        return match($this) {
            self::HOUSE        => 'bg-blue-100 text-blue-800',
            self::APARTMENT       => 'bg-indigo-100 text-indigo-800',
            self::VILLA    => 'bg-purple-100 text-purple-800',
            self::COMMERCIAL    => 'bg-yellow-100 text-yellow-800',
            self::LAND    => 'bg-teal-100 text-teal-800',
            self::OTHER    => 'bg-gray-100 text-gray-800',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}