import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { IPaginatedData, ISite, PageProps } from "@/types";
import PrimaryButton from "@/Components/PrimaryButton";
import Container from "@/Components/Container";
import SiteListTable from "@/Pages/Site/Partials/SiteListTable";
import Pagination from "@/Components/Pagination";

export default function Index({
    auth,
    sites,
}: PageProps<{
    sites: IPaginatedData<ISite>;
}>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Site List
                </h2>
            }
        >
            <Head title="Site List" />

            <Container className="mt-6 text-end">
                <Link href={route("sites.create")}>
                    <PrimaryButton>Add New Site</PrimaryButton>
                </Link>
            </Container>

            <div className="py-6">
                <Container>
                    <div className="bg-white shadow sm:rounded-lg">
                        <SiteListTable sites={sites.data} />
                    </div>
                    <Pagination links={sites.links} />
                </Container>
            </div>
        </AuthenticatedLayout>
    );
}
