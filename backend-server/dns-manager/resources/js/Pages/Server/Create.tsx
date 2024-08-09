import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import ServerCreateForm from "@/Pages/Server/Partials/ServerCreateForm";

export default function Create({ auth }: PageProps) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Add a new Server
                </h2>
            }
        >
            <Head title="Add a new server" />

            <div className="py-6">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <ServerCreateForm />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
