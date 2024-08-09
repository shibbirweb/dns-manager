<?php

namespace App\Repositories\MagicLoginTokenRepository\Contracts;

use App\Models\MagicLoginToken;

interface MagicLoginTokenRepositoryInterface
{
    public function create(array $data): MagicLoginToken;
}
