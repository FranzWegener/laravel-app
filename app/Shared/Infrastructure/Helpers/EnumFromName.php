<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Helpers;

trait EnumFromName
{
    public static function fromName(string $name): self
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum " . self::class);
    }
}
