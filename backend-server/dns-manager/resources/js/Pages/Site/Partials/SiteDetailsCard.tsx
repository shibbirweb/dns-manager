import { ISite } from "@/types";
import { Link } from "@inertiajs/react";
import useToastHook from "@/Hooks/useToastHook";
import CopyToClipboardIcon from "@/Components/icons/CopyToClipboardIcon";
import RegenerateSecretKeyForm from "@/Pages/Site/Partials/RegenerateSecretKeyForm";

export default function SiteDetailsCard({
    site,
}: Readonly<{
    site: ISite;
}>) {
    const useToast = useToastHook();
    const onSecretKeyClickHandler = () => {
        if (!site.secret_key || !navigator.clipboard) return;
        navigator.clipboard.writeText(site.secret_key);
        useToast("Secret key copied to clipboard", "success");
    };

    return (
        <div className="overflow-hidden bg-white shadow sm:rounded-lg">
            <div className="px-4 py-5 sm:px-6">
                <h3 className="text-lg font-medium leading-6 text-gray-900">
                    Site Information
                </h3>
                <p className="mt-1 max-w-2xl text-sm text-gray-500">
                    Details about the site.
                </p>
            </div>
            <div className="border-t border-gray-200">
                <dl>
                    <div className="px-4 py-5 odd:bg-gray-50 even:bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt className="text-sm font-medium text-gray-500">
                            Server
                        </dt>
                        <dd className="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {site.server?.name}({site.server?.host}:
                            {site.server?.port})
                        </dd>
                    </div>
                    <div className="px-4 py-5 odd:bg-gray-50 even:bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt className="text-sm font-medium text-gray-500">
                            Name
                        </dt>
                        <dd className="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {site.name}
                        </dd>
                    </div>
                    <div className="px-4 py-5 odd:bg-gray-50 even:bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt className="text-sm font-medium text-gray-500">
                            URL
                        </dt>
                        <dd className="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {site.url}
                        </dd>
                    </div>
                    <div className="px-4 py-5 odd:bg-gray-50 even:bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt className="text-sm font-medium text-gray-500">
                            Site Path
                        </dt>
                        <dd className="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {site.site_path}
                        </dd>
                    </div>
                    <div className="px-4 py-5 odd:bg-gray-50 even:bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt className="text-sm font-medium text-gray-500">
                            Admin Email
                        </dt>
                        <dd className="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {site.admin_email}
                        </dd>
                    </div>
                    <div className="px-4 py-5 odd:bg-gray-50 even:bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt className="text-sm font-medium text-gray-500">
                            Secret Key
                        </dt>
                        <dd className="mt-1 flex gap-2 text-sm text-gray-900 sm:col-span-2">
                            <div className="flex items-center gap-2">
                                {site.secret_key}
                                <button
                                    type="button"
                                    onClick={onSecretKeyClickHandler}
                                    title="Copy to clipboard"
                                >
                                    <CopyToClipboardIcon />
                                </button>
                            </div>
                            <RegenerateSecretKeyForm site={site} />
                        </dd>
                    </div>
                </dl>
            </div>

            <div className="flex flex-wrap items-center justify-evenly gap-2 px-4 py-5 sm:px-6">
                <Link
                    href={route("sites.redirect-to-site-dashboard", site.id)}
                    as="button"
                    method="post"
                    className="font-medium text-blue-600 hover:underline"
                >
                    Go to WP Dashboard
                </Link>
                <Link
                    href={route("sites.edit", site.id)}
                    className="font-medium text-blue-600 hover:underline"
                >
                    Edit
                </Link>
                <Link
                    href={route("sites.destroy", site.id)}
                    method="delete"
                    className="font-medium text-blue-600 hover:underline"
                    as="button"
                    type="button"
                    onClick={(e) => {
                        if (
                            !confirm(
                                "Are you sure you want to remove this site?",
                            )
                        ) {
                            e.preventDefault();
                        }
                    }}
                >
                    Remove
                </Link>
            </div>
        </div>
    );
}
