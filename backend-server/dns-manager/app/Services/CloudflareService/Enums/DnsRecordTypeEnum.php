<?php

namespace App\Services\CloudflareService\Enums;

use App\Services\CloudflareService\Enums\Traits\EnumHelperTrait;

enum DnsRecordTypeEnum: string
{
    use EnumHelperTrait;

    case A = 'A';
    case TXT = 'TXT';
    case CNAME = 'CNAME';
}
