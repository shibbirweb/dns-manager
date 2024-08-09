<?php

namespace App\Http\Controllers;

use App\Http\Requests\CloudflareDnsRecordStoreRequest;
use App\Repositories\CloudflareIntegrationRepository\CloudflareIntegrationRepository;
use App\Services\CloudflareService\CloudflareService;
use App\Services\CloudflareService\DTOs\DNSRecordStoreErrorDTO;
use App\Services\CloudflareService\Enums\DnsRecordTypeEnum;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CloudflareDNSController extends Controller
{
    public function index(CloudflareIntegrationRepository $integrationRepository)
    {
        $cloudflareIntegration = $integrationRepository->findByUserId(userId: auth()->id());

        if ($cloudflareIntegration) {
            $cloudflareService = new CloudflareService(token: $cloudflareIntegration->api_token);
            $cloudflareDnsZones = $cloudflareService->zones();
            $cloudflareDnsRecords = $cloudflareService->getAllDnsRecords();
        }

        return Inertia::render('CloudflareDNS/Index', [
            'cloudflareIntegration' => $cloudflareIntegration,
            'cloudflareDnsRecords' => $cloudflareDnsRecords ?? collect([]),
            'cloudflareDnsZones' => $cloudflareDnsZones ?? collect([]),
            'cloudflareDnsRecordTypes' => DnsRecordTypeEnum::values(),
        ]);
    }

    public function store(CloudflareDnsRecordStoreRequest $request, CloudflareIntegrationRepository $integrationRepository)
    {
        $cloudflareIntegration = $integrationRepository->findByUserId(userId: auth()->id());

        if (!$cloudflareIntegration) {
            return redirect()->back()->with('error', 'Cloudflare integration not found');
        }

        $cloudflareService = new CloudflareService(token: $cloudflareIntegration->api_token);

        $record = $cloudflareService->createDnsRecord(
            zoneId: $request->zone_id,
            type: $request->type,
            name: $request->name,
            content: $request->content,
        );

        if ($record instanceof DNSRecordStoreErrorDTO) {
            return redirect()->back()
                ->withErrors(['content' => $record->message]);
        }

        return redirect()->back()
            ->with('success', 'DNS record created successfully');
    }
}
