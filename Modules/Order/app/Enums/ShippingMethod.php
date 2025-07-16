<?php

namespace Modules\Order\Enums;

enum ShippingMethod: int
{
    case POST   = 0;
    case TIPAX  = 1;
    case CHAPAR = 2;

    public function price(): int
    {
        return match ($this) {
            self::POST   => 40_000,
            self::TIPAX  => 30_000,
            self::CHAPAR => 60_000,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::POST   => __('Shipping via Post'),
            self::TIPAX  => __('Shipping via Tipax'),
            self::CHAPAR => __('Shipping via Chapar'),
        };
    }

    public static function fromName(string $name): self
    {
        return match (strtolower($name)) {
            'post' => self::POST,
            'tipax' => self::TIPAX,
            'chapar' => self::CHAPAR,
            default => throw new \InvalidArgumentException("Invalid shipping method: $name")
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($item) => [$item->name => $item->value])
            ->toArray();
    }
}
