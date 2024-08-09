<?php

namespace App\Repositories\ServerRepository;

use App\Models\Server;
use App\Repositories\Repository;
use App\Repositories\ServerRepository\Contracts\ServerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ServerRepository extends Repository implements ServerRepositoryInterface
{
    protected function setModel(): string
    {
        return Server::class;
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data): Server
    {
        return $this->model->create($data);
    }

    public function find(string $id): Server
    {
        return $this->model->findOrFail($id);
    }

    public function update(string $id, array $data): Server
    {
        $server = $this->find($id);

        return tap($server)->update($data);
    }

    public function delete(string $id): Server
    {
        $server = $this->find($id);

        $server->delete();

        return $server;
    }

    public function all($select = "*"): Collection
    {
        return $this->model->all($select);
    }
}
