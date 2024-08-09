<?php

namespace App\Repositories\CloudflareIntegrationRepository;

use App\Models\CloudflareIntegration;
use App\Repositories\CloudflareIntegrationRepository\Contracts\CloudflareIntegrationRepositoryInterface;
use App\Repositories\Repository;

class CloudflareIntegrationRepository extends Repository implements CloudflareIntegrationRepositoryInterface
{
    protected function setModel(): string
    {
        return CloudflareIntegration::class;
    }

    public function create(array $data): CloudflareIntegration
    {
        return $this->model->create($data);
    }

    public function delete(string | CloudflareIntegration $idOrCloudflareIntegration): CloudflareIntegration
    {
        if ($idOrCloudflareIntegration instanceof CloudflareIntegration) {
            $idOrCloudflareIntegration->delete();
            return $idOrCloudflareIntegration;
        }

        $idOrCloudflareIntegration = $this->find($idOrCloudflareIntegration);

        $idOrCloudflareIntegration->delete();

        return $idOrCloudflareIntegration;
    }

    public function findByUserId(int $userId): ?CloudflareIntegration
    {
        return $this->model
            ->where('user_id', $userId)
            ->first();
    }

    public function find(string $id): ?CloudflareIntegration
    {
        return $this->model->find($id);
    }
}
