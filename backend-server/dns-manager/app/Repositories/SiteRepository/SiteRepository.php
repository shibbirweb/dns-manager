<?php

namespace App\Repositories\SiteRepository;

use App\Models\Site;
use App\Repositories\Repository;
use App\Repositories\SiteRepository\Contracts\SiteRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SiteRepository extends Repository implements SiteRepositoryInterface
{

    protected function setModel(): string
    {
        return Site::class;
    }

    public function create(array $data): Site
    {
        return $this->model->create($data);
    }

    public function paginate(int $perPage = 10, $with = []): LengthAwarePaginator
    {
        return $this->model
            ->with($with)
            ->paginate($perPage);
    }

    public function find(string $id, array|string $with = []): Site
    {
        return $this->model
            ->with($with)
            ->findOrFail($id);
    }

    public function update(string $id, array $data): Site
    {
        $site = $this->find($id);

        return tap($site)
            ->update($data);
    }

    public function delete(string $id): Site
    {
        $site = $this->find($id);

        $site->delete();

        return $site;
    }
}
