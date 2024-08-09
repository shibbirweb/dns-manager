import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import {
    DnsRecordType,
    ICloudflareDnsZone,
    ICloudflareIntegration,
    IDnsCloudflareRecord,
    PageProps,
} from "@/types";
import Container from "@/Components/Container";
import CloudflareIntegrationForm from "@/Pages/CloudflareDNS/Partials/CloudflareIntegrationForm";
import ConnectedCloudflareAccount from "@/Pages/CloudflareDNS/Partials/ConnectedCloudflareAccount";
import DNSRecordListTable from "@/Pages/CloudflareDNS/Partials/DNSRecordListTable";
import AddDnsRecordForm from "@/Pages/CloudflareDNS/Partials/AddDnsRecordForm";

export default function Index({
    auth,
    cloudflareIntegration,
    cloudflareDnsRecords = [],
    cloudflareDnsRecordTypes = [],
    cloudflareDnsZones = [],
}: PageProps<{
    cloudflareIntegration: ICloudflareIntegration | null;
    cloudflareDnsRecords: IDnsCloudflareRecord[];
    cloudflareDnsRecordTypes: DnsRecordType[];
    cloudflareDnsZones: ICloudflareDnsZone[];
}>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Cloudflare DNS
                </h2>
            }
        >
            <Head title="Cloudflare DNS" />

            <Container className="mt-6 text-end">
                {cloudflareIntegration ? (
                    <ConnectedCloudflareAccount
                        cloudflareIntegration={cloudflareIntegration}
                    />
                ) : (
                    <CloudflareIntegrationForm />
                )}
            </Container>

            <div className="py-6">
                <Container>
                    <div className="bg-white shadow sm:rounded-lg">
                        {cloudflareIntegration ? (
                            <>
                                <AddDnsRecordForm
                                    dnsRecordTypes={cloudflareDnsRecordTypes}
                                    cloudflareDnsZones={cloudflareDnsZones}
                                />
                                <DNSRecordListTable
                                    cloudflareDnsRecords={cloudflareDnsRecords}
                                />
                            </>
                        ) : (
                            <div className="p-4 text-center text-gray-500">
                                Connect your Cloudflare account to view DNS
                                records
                            </div>
                        )}
                    </div>
                </Container>
            </div>
        </AuthenticatedLayout>
    );
}
