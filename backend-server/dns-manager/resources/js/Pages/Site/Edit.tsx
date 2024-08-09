import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { IServer, ISite, PageProps } from "@/types";
import SiteEditForm from "@/Pages/Site/Partials/SiteEditForm";

export default function Edit({
    auth,
    site,
    servers,
}: PageProps<{
    servers: IServer[];
    site: ISite;
}>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Edit Site
                </h2>
            }
        >
            <Head title="Edit Site" />

            <div className="py-6">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <SiteEditForm site={site} servers={servers} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
