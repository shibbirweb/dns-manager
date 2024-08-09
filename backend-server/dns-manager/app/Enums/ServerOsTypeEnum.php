<?php

namespace App\Enums;

enum ServerOsTypeEnum: string
{
    case Linux = 'linux';
    case MacOS = 'macos';
    case Windows = 'windows';
    case Unknown = 'unknown';
}
