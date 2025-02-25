<?php

namespace App\Enums;

enum RoomStatusEnum: string
{

    case READY     = 'ready';
    case PENDING_CLEANUP = 'pending_cleanup';
    case RESERVED  = 'reserved';

    public static function values(): array
    {

        return array_column(self::cases(), 'value');
    }
}
