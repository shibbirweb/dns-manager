<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteStoreRequest;
use App\Http\Requests\SiteUpdateRequest;
use App\Repositories\ServerRepository\Contracts\ServerRepositoryInterface;
use App\Repositories\SiteRepository\Contracts\SiteRepositoryInterface;
use App\Services\SiteService\MagicLoginService;
use App\Services\SiteService\SiteService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SiteRepositoryInterface $siteRepository)
    {
        return Inertia::render('Site/Index', [
            'sites' => $siteRepository->paginate(perPage: 2, with: ['server']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ServerRepositoryInterface $serverRepository)
    {
        return Inertia::render('Site/Create', [
            'servers' => $serverRepository->all(['id', 'name', 'host', 'port', 'admin_email']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(SiteStoreRequest $request, SiteService $siteService)
    {
        try {
            $site = $siteService->storeSite(data: $request->safe()->only([
                'server_id',
                'name',
                'url',
                'admin_email',
                'site_path',
            ]));

            $siteService->createSiteDirectory(site: $site);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withError('Failed to add site. ' . $e->getMessage());
        }

        DB::commit();

        return redirect()
            ->route('sites.show', $site->id)
            ->withSuccess('Site added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, SiteRepositoryInterface $siteRepository)
    {
        return Inertia::render('Site/Show', [
            'site' => $siteRepository->find(id: $id, with: ['server']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, SiteRepositoryInterface $siteRepository, ServerRepositoryInterface $serverRepository)
    {
        return Inertia::render('Site/Edit', [
            'site' => $siteRepository->find(id: $id, with: ['server']),
            'servers' => $serverRepository->all(['id', 'name', 'host', 'port']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteUpdateRequest $request, string $id, SiteRepositoryInterface $siteRepository, SiteService $siteService)
    {
        DB::transaction(function () use ($siteRepository, $request, $id, $siteService) {
            $oldSitePath = $siteRepository->find(id: $id)->site_path;

            $site = $siteRepository->update($id, $request->safe()->only([
                'server_id',
                'name',
                'url',
                'admin_email',
                'site_path',
            ]));

            $siteService->renameSiteDirectory(
                site: $site,
                oldPath: $oldSitePath,
                newPath: $site->site_path
            );
        });

        return redirect()
            ->route('sites.index')
            ->withSuccess('Site information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, SiteRepositoryInterface $siteRepository)
    {
        $siteRepository->delete($id);

        return redirect()
            ->route('sites.index')
            ->withSuccess('Site removed successfully.');
    }

    public function redirectToSiteDashboard(string $id, SiteRepositoryInterface $siteRepository, MagicLoginService $magicLoginService)
    {
        $site = $siteRepository->find(id: $id);

        $redirectUrl = $magicLoginService->generateSiteDashboardRedirectUrl(site: $site);

        return Inertia::location($redirectUrl);
    }

    public function regenerateSecretKey(string $id, SiteService $siteService)
    {
        $siteService->regenerateSecretKey(siteId: $id);

        return redirect()
            ->route('sites.show', $id)
            ->withSuccess('Secret key regenerated successfully.');
    }
}
