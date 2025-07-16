<?php

namespace Modules\Order\Enums;

enum OrderStatus: int
{
    case PAID = 0;
    case SENT = 1;
    case DELIVERED = 2;

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($item) => [$item->name => $item->value])
            ->toArray();
    }
}
