import { ISite } from "@/types";
import useToastHook from "@/Hooks/useToastHook";
import SecondaryButton from "@/Components/SecondaryButton";
import { useForm } from "@inertiajs/react";
import { MouseEventHandler } from "react";

export default function RegenerateSecretKeyForm({
    site,
}: Readonly<{
    site: ISite;
}>) {
    const toast = useToastHook();
    const { post, processing } = useForm();

    const onSecondaryButtonClickHandler: MouseEventHandler<
        HTMLButtonElement
    > = (event) => {
        if (!confirm("Are you sure you want to regenerate secret key?")) {
            event.preventDefault();
            return;
        }

        post(route("sites.secret-key.regenerate", site.id), {
            preserveScroll: true,
            onSuccess: () => {
                toast("Secret key regenerated successfully", "success");
            },
            onError: () => {
                toast("Failed to regenerate secret key", "error");
            },
        });
    };

    return (
        <SecondaryButton
            type="button"
            disabled={processing}
            onClick={onSecondaryButtonClickHandler}
        >
            Regenerate Secret Key
        </SecondaryButton>
    );
}
