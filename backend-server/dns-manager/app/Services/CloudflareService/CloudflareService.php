<?php

namespace App\Services\CloudflareService;

use App\Services\CloudflareService\DTOs\DNSRecordDTO;
use App\Services\CloudflareService\DTOs\DNSRecordStoreErrorDTO;
use App\Services\CloudflareService\DTOs\ZoneDTO;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareService
{

    public function __construct(
        protected string $token
    )
    {
        //
    }

    protected function apiClient(): PendingRequest
    {
        return Http::cloudflare(token: $this->token);
    }

    /**
     * @throws ConnectionException
     */
    public function isValidApiToken(): bool
    {
        $response = $this->apiClient()
            ->get('/user/tokens/verify');

        if ($response->failed()) {
            Log::error('Failed to verify token', [
                'response' => $response->json(),
            ]);
            return false;
        }

        return $response->json('result.status') === 'active';
    }

    /**
     * @return Collection<ZoneDTO>
     * @throws ConnectionException
     */
    public function zones(): Collection
    {
        $response = $this->apiClient()
            ->get('/zones');

        if ($response->failed()) {
            Log::error('Failed to fetch zones', [
                'response' => $response->json(),
            ]);
            return collect([]);
        }

        return $response->collect('result')
            ->map(fn($zone) => new ZoneDTO(
                id: $zone['id'],
                name: $zone['name'],
            ));
    }

    /**
     * @return Collection<DNSRecordDTO>
     * @throws ConnectionException
     */
    public function getAllDnsRecords(): Collection
    {
        $zones = $this->zones();

        return $zones
            ->map(fn($zone) => $this->getDnsRecords(zoneId: $zone->id))
            ->flatten();
    }

    /**
     * @return Collection<DNSRecordDTO>
     * @throws ConnectionException
     */
    public function getDnsRecords(string $zoneId): Collection
    {
        $response = $this->apiClient()
            ->get("/zones/{$zoneId}/dns_records");

        if ($response->failed()) {
            Log::error('Failed to fetch DNS records', [
                'response' => $response->json(),
            ]);
            return collect([]);
        }

        return $response->collect('result')
            ->map(fn($record) => new DNSRecordDTO(
                id: $record['id'],
                zoneId: $record['zone_id'],
                zoneName: $record['zone_name'],
                name: $record['name'],
                type: $record['type'],
                content: $record['content'],
                proxied: $record['proxied'],
                proxiable: $record['proxiable'],
                ttl: $record['ttl'],
            ));
    }

    public function createDnsRecord(string $zoneId, string $type, string $name, string $content): null | DNSRecordDTO | DNSRecordStoreErrorDTO
    {
        $response = $this->apiClient()
            ->post("/zones/{$zoneId}/dns_records", [
                'type' => $type,
                'name' => $name,
                'content' => $content,
            ]);

        if ($response->failed()) {
            Log::error('Failed to store DNS record', [
                'response' => $response->json(),
            ]);

            return new DNSRecordStoreErrorDTO(
                code: $response->json('errors.0.code'),
                message: $response->json('errors.0.message'),
            );
        }

        $rawData = $response->json('result');

        return new DNSRecordDTO(
            id: $rawData['id'],
            zoneId: $rawData['zone_id'],
            zoneName: $rawData['zone_name'],
            name: $rawData['name'],
            type: $rawData['type'],
            content: $rawData['content'],
            proxied: $rawData['proxied'],
            proxiable: $rawData['proxiable'],
            ttl: $rawData['ttl'],
        );
    }
}
