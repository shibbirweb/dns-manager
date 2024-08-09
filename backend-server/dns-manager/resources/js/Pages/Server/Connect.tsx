import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { IServer, PageProps } from "@/types";
import Container from "@/Components/Container";
import ServerConnectWindow from "@/Pages/Server/Partials/ServerConnectWindow";

export default function Index({
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
                    Server Connect
                </h2>
            }
        >
            <Head title="Server Connect" />

            <Container className="mt-6 flex items-center justify-between">
                <Link href={route("servers.index")}>Back to Server List</Link>
            </Container>

            <div className="py-6">
                <Container>
                    <div className="bg-white shadow sm:rounded-lg">
                        <ServerConnectWindow server={server} />
                    </div>
                </Container>
            </div>
        </AuthenticatedLayout>
    );
}
