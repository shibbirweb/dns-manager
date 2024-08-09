<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected Model $model;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    abstract protected function setModel(): string;

    /**
     * @throws BindingResolutionException
     */
    private function resolveModel(): Model
    {
        return app()->make($this->setModel());
    }
}
