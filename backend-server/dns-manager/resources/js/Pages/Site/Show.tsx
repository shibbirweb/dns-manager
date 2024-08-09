import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { ISite, PageProps } from "@/types";
import PrimaryButton from "@/Components/PrimaryButton";
import Container from "@/Components/Container";
import SiteDetailsCard from "@/Pages/Site/Partials/SiteDetailsCard";

export default function Index({
    auth,
    site,
}: PageProps<{
    site: ISite;
}>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Site Details
                </h2>
            }
        >
            <Head title="Site Details" />

            <Container className="mt-6 flex items-center justify-between">
                <Link href={route("sites.index")}>Back to Site List</Link>

                <Link href={route("sites.create")}>
                    <PrimaryButton>Add New Site</PrimaryButton>
                </Link>
            </Container>

            <div className="py-6">
                <Container>
                    <SiteDetailsCard site={site} />
                </Container>
            </div>
        </AuthenticatedLayout>
    );
}
