import React, { FC, HTMLAttributes, MouseEventHandler } from "react";
import { router, useForm } from "@inertiajs/react";
import DangerButton from "@/Components/DangerButton";

const CloudflareIntegrationRemoveButton: FC<
    HTMLAttributes<HTMLButtonElement>
> = () => {
    const { delete: destroy, errors, processing } = useForm<{}>({});
    const onClickHandler: MouseEventHandler = (event) => {
        event.preventDefault();

        if (!confirm("Are you sure you want to unlink cloudflare account?")) {
            return;
        }

        destroy(route("cloudflare-integration.destroy"), {
            onSuccess: () => router.reload(),
        });
    };

    return (
        <DangerButton
            type="button"
            onClick={onClickHandler}
            disabled={processing}
        >
            Remove Cloudflare Account
        </DangerButton>
    );
};

export default CloudflareIntegrationRemoveButton;
