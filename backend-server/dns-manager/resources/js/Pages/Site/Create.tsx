import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { IServer, PageProps } from "@/types";
import SiteCreateForm from "@/Pages/Site/Partials/SiteCreateForm";

export default function Create({
    auth,
    servers,
}: PageProps<{
    servers: IServer[];
}>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Add a new Site
                </h2>
            }
        >
            <Head title="Create Site" />

            <div className="py-6">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <SiteCreateForm servers={servers} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
