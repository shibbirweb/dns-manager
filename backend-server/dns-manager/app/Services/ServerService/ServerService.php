<?php

namespace App\Services\ServerService;

use App\Enums\ServerOsTypeEnum;
use App\Exceptions\ServerLoginFailedException;
use App\Exceptions\ServerUnknownOsException;
use App\Models\Server;

class ServerService
{
    /**
     * Create a path on a server
     *
     * @param Server $server
     * @param string $path
     *
     * @return string
     *
     * @throws ServerLoginFailedException
     */
    public function createPath(Server $server, string $path): string
    {

        return $server->actionExecuteCommand("mkdir $path");
    }

    /**
     * Rename a path on a server
     *
     * @param Server $server
     * @param string $oldPath
     * @param string $newPath
     *
     * @return string
     *
     * @throws ServerUnknownOsException
     * @throws ServerLoginFailedException
     */
    public function renamePath(Server $server, string $oldPath, string $newPath): string
    {
        $command =  match ($this->getOsType($server)) {
            ServerOsTypeEnum::Windows => "ren \"$oldPath\" \"$newPath\"",
            ServerOsTypeEnum::MacOS, ServerOsTypeEnum::Linux => "mv \"$oldPath\" \"$newPath\"",
            default => throw new ServerUnknownOsException("Unknown OS type"),
        };

        return $server->actionExecuteCommand($command);
    }

    public function getOsType(Server $server): ServerOsTypeEnum
    {
        $result = $server->actionExecuteCommand(command: "uname -s");

        // Try to detect Linux or macOS
        if (stripos($result, 'Linux') !== false) {
            return ServerOsTypeEnum::Linux;
        } elseif (stripos($result, 'Darwin') !== false) {
            return ServerOsTypeEnum::MacOS;
        }

        // Try to detect Windows
        $result = $server->actionExecuteCommand(command: 'ver');
        if (stripos($result, 'Windows') !== false) {
            return ServerOsTypeEnum::Windows;
        }

        return ServerOsTypeEnum::Unknown;
    }
}
