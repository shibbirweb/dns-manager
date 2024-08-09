import CloudflareIntegrationRemoveButton from "@/Pages/CloudflareDNS/Partials/CloudflareIntegrationRemoveButton";
import { FC } from "react";
import { ICloudflareIntegration } from "@/types";

const ConnectedCloudflareAccount: FC<{
    cloudflareIntegration: ICloudflareIntegration;
}> = ({ cloudflareIntegration }) => {
    return (
        <div className="flex flex-wrap items-center justify-between">
            <div className="space-x-1">
                <span className="text-gray-600">Connected as</span>
                <span className="font-semibold text-gray-900">
                    {cloudflareIntegration.name}({cloudflareIntegration.email})
                </span>
            </div>
            <CloudflareIntegrationRemoveButton />
        </div>
    );
};

export default ConnectedCloudflareAccount;
