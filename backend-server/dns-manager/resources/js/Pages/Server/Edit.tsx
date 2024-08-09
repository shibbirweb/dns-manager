import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { IServer, PageProps } from "@/types";
import ServerEditForm from "@/Pages/Server/Partials/ServerEditForm";

export default function Edit({
    auth,
    server,
}: PageProps<{
    server: IServer;
}>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Edit Server
                </h2>
            }
        >
            <Head title="Edit Server" />

            <div className="py-6">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <ServerEditForm server={server} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
