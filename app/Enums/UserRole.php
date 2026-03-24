<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case AGENT = 2;
    case CUSTOMER = 3;

    public function label(): string
    {
        return match ($this) {
            static::ADMIN => 'Admin',
            static::AGENT => 'Agent',
            static::CUSTOMER => 'Customer',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}