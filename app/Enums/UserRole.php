<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case VENDOR = 'vendor';
    case FREELANCER = 'freelancer';
    case CLIENT = 'client';
    case SUPPORT = 'support';

    /**
     * Get all role values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get role label
     */
    public function label(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Super Administrator',
            self::ADMIN => 'Administrator',
            self::MANAGER => 'Manager',
            self::VENDOR => 'Vendor',
            self::FREELANCER => 'Freelancer',
            self::CLIENT => 'Client',
            self::SUPPORT => 'Support Staff',
        };
    }

    /**
     * Check if role has admin privileges
     */
    public function isAdmin(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::ADMIN, self::MANAGER]);
    }

    /**
     * Check if role can sell
     */
    public function canSell(): bool
    {
        return in_array($this, [self::VENDOR, self::FREELANCER]);
    }
}
