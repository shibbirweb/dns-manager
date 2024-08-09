<?php

namespace App\Services\CloudflareService\DTOs;

readonly class ZoneDTO
{
    public function __construct(
        public string $id,
        public string $name,
    )
    {
        //
    }
}
