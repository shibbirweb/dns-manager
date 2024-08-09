<?php

namespace App\Services\CloudflareService\Enums\Traits;

trait EnumHelperTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
