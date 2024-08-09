<?php

namespace App\Repositories\ServerRepository\Contracts;

use App\Models\Server;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ServerRepositoryInterface
{
    public function all($select = "*"): Collection;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Server;

    public function find(string $id): Server;

    public function update(string $id, array $data): Server;

    public function delete(string $id): Server;
}
