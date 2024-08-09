<?php

namespace App\Repositories\SiteRepository\Contracts;

use App\Models\Site;
use Illuminate\Pagination\LengthAwarePaginator;

interface SiteRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Site;

    public function find(string $id, array|string $with = []): Site;

    public function update(string $id, array $data): Site;

    public function delete(string $id): Site;
}
