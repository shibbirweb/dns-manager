import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { IPaginatedData, IServer, PageProps } from "@/types";
import ServerListTable from "@/Pages/Server/Partials/ServerListTable";
import PrimaryButton from "@/Components/PrimaryButton";
import Container from "@/Components/Container";
import Pagination from "@/Components/Pagination";

export default function Index({
    auth,
    servers,
    flash,
}: PageProps<{
    servers: IPaginatedData<IServer>;
}>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Server List
                </h2>
            }
        >
            <Head title="Server List" />

            <Container className="mt-6 text-end">
                <Link href={route("servers.create")}>
                    <PrimaryButton>Add a new Server</PrimaryButton>
                </Link>
            </Container>

            <div className="py-6">
                <Container>
                    <div className="bg-white shadow sm:rounded-lg">
                        <ServerListTable servers={servers.data} />
                    </div>
                    <Pagination links={servers.links} />
                </Container>
            </div>
        </AuthenticatedLayout>
    );
}
