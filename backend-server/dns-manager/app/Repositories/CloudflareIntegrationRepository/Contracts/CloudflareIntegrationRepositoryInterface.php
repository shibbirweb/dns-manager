<?php

namespace App\Repositories\CloudflareIntegrationRepository\Contracts;

use App\Models\CloudflareIntegration;

interface CloudflareIntegrationRepositoryInterface
{
    public function create(array $data): CloudflareIntegration;

    public function find(string $id): ?CloudflareIntegration;

    public function findByUserId(int $userId): ?CloudflareIntegration;

    public function delete(string | CloudflareIntegration $idOrCloudflareIntegration): CloudflareIntegration;
}
