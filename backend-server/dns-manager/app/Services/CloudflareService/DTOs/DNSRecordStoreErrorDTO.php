<?php

namespace App\Services\CloudflareService\DTOs;

readonly class DNSRecordStoreErrorDTO
{
    public function __construct(
        public string $code,
        public string $message,
    )
    {
        //
    }

}
