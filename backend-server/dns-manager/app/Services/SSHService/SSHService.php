<?php

namespace App\Services\SSHService;

use Illuminate\Support\Facades\Log;
use phpseclib3\Net\SSH2;

class SSHService
{
    private SSH2 $ssh;

    public function __construct(
        protected string $host,
        protected int    $port,
    )
    {
        $this->connect();
    }

    protected function connect(): void
    {
        $this->ssh = new SSH2(host: $this->host, port: $this->port);
    }

    public function login(string $username, string $password): bool
    {
        try {
            return $this->ssh->login($username, $password);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['host' => $this->host, 'port' => $this->port, 'username' => $username]);
            return false;
        }
    }

    public function execute(string $command): string
    {
        return $this->ssh->exec($command);
    }

    public function disconnect(): void
    {
        $this->ssh->disconnect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}
