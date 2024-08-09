<?php

namespace App\Services\SiteService;

use App\Exceptions\ServerLoginFailedException;
use App\Models\Site;
use App\Repositories\SiteRepository\Contracts\SiteRepositoryInterface;
use App\Services\ServerService\ServerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SiteService
{
    public function __construct(
        protected SiteRepositoryInterface $siteRepository
    )
    {
        //
    }

    public function storeSite(array $data): Site
    {
        return $this->siteRepository
            ->create([
                ...$data,
                ...[
                    'secret_key' => $this->generateSecretKey(),
                ],
            ]);
    }

    private function generateSecretKey(): string
    {
        return Str::random(30);
    }

    public function regenerateSecretKey(string $siteId): Site
    {
        $site = $this->siteRepository->find(id: $siteId);

        tap($site)
            ->update(['secret_key' => $this->generateSecretKey()]);

        return $site;
    }

    public function createSiteDirectory(Site $site): string
    {
        $serverService = app(ServerService::class);

        $server = $site->server;

        if (!$server) {
            throw new \Exception("Server not found for site {$site->name}");
        }

        return $serverService->createPath($server, $site->site_path);
    }


    public function renameSiteDirectory(Site $site, string $oldPath, string $newPath): bool
    {
        $serverService = app(ServerService::class);

        $server = $site->server;

        try {
            $serverService->renamePath(server: $server, oldPath: $oldPath, newPath: $newPath);
        }catch (\Exception $e){
            Log::error($e->getMessage(), ['site' => $site->name, 'oldPath' => $oldPath, 'newPath' => $newPath]);
            return false;
        }

        return true;
    }
}
