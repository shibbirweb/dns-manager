<?php

namespace App\Services\CloudflareService\DTOs;

readonly class DNSRecordDTO
{
    public function __construct(
        public string $id,
        public string $zoneId,
        public string $zoneName,
        public string $name,
        public string $type,
        public string $content,
        public bool $proxied,
        public bool $proxiable,
        public string $ttl,
    )
    {
        //
    }

    public function formattedTtl(): string
    {
        if ($this->ttl == 1) {
            return 'Auto';
        }
        return $this->ttl;
    }
}
