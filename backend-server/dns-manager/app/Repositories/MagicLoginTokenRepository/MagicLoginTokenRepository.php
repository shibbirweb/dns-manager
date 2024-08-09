<?php

namespace App\Repositories\MagicLoginTokenRepository;

use App\Models\MagicLoginToken;
use App\Repositories\MagicLoginTokenRepository\Contracts\MagicLoginTokenRepositoryInterface;

class MagicLoginTokenRepository implements MagicLoginTokenRepositoryInterface
{
    public function create(array $data): MagicLoginToken
    {
        return MagicLoginToken::create($data);
    }
}
