<?php

namespace App\Http\Controllers;

use App\Http\Requests\CloudflareIntegrationStoreRequest;
use App\Repositories\CloudflareIntegrationRepository\Contracts\CloudflareIntegrationRepositoryInterface;

class CloudflareIntegrationController extends Controller
{
    public function store(CloudflareIntegrationStoreRequest $request, CloudflareIntegrationRepositoryInterface $integrationRepository)
    {
        $integrationRepository->create(data: $request->safe()->only(
            [
                'name',
                'email',
                'api_token'
            ]) + [
                'user_id' => auth()->id()
            ]);

        session()->flash('success', 'Cloudflare account linked successfully');
    }

    public function destroy(CloudflareIntegrationRepositoryInterface $cloudflareIntegrationRepository)
    {
        $cloudflareIntegration = $cloudflareIntegrationRepository->findByUserId(userId: auth()->id());

        if(!$cloudflareIntegration) {
            session()->flash('error', 'Cloudflare account not linked');
            return;
        }

        $cloudflareIntegrationRepository->delete(idOrCloudflareIntegration: $cloudflareIntegration);

        session()->flash('success', 'Cloudflare account unlinked successfully');
    }
}
