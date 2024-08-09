<?php

namespace App\Models;

use App\Exceptions\ServerLoginFailedException;
use App\Services\SSHService\SSHService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model
{
    use HasFactory;

    private $serverConnection = null;

    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'password',
    ];

    protected $casts = [
        'password' => 'encrypted',
    ];

    /*=== Relationship Start ===*/
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }
    /*=== Relationship End ===*/

    /*=== Action Start ===*/

    /**
     * Get the server connection
     *
     * @return SSHService
     *
     * @throws ServerLoginFailedException
     */
    public function actionGetServerConnection(): SSHService
    {
        if ($this->serverConnection === null) {
            $this->serverConnection = new SSHService($this->host, $this->port);
            if (!$this->serverConnection->login($this->username, $this->password)) {
                throw new ServerLoginFailedException("Failed to login to server {$this->name}");
            }
        }
        return $this->serverConnection;
    }

    /**
     * Execute a command on the server
     *
     * @param string $command
     *
     * @return string
     *
     * @throws ServerLoginFailedException
     */
    public function actionExecuteCommand(string $command): string
    {
        return $this->actionGetServerConnection()
            ->execute(command: $command);
    }
    /*=== Action End ===*/
}
