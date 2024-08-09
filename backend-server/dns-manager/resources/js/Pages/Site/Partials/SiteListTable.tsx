import { Table, TBody, Td, Th, THead, Tr } from "@/Components/table";
import { ISite } from "@/types";
import { Link } from "@inertiajs/react";

export default function SiteListTable({
    sites = [],
}: Readonly<{
    sites: ISite[];
}>) {
    const siteRows =
        sites.length === 0 ? (
            <Tr>
                <Td colSpan={4} className="text-center">
                    No site available
                </Td>
            </Tr>
        ) : (
            <>
                {sites.map((site) => (
                    <Tr key={site.id} className="bg-white hover:bg-gray-50">
                        <Td>
                            {site.server?.host}:{site.server?.port}
                        </Td>
                        <Th className="whitespace-nowrap py-4 font-medium text-gray-900">
                            {site.name}
                        </Th>
                        <Td>{site.url}</Td>
                        <Td className="flex flex-wrap items-center justify-center gap-2 text-right lg:justify-end">
                            <Link
                                href={route(
                                    "sites.redirect-to-site-dashboard",
                                    site.id,
                                )}
                                as="button"
                                method="post"
                                className="font-medium text-blue-600 hover:underline"
                            >
                                Go to WP Dashboard
                            </Link>
                            <Link
                                href={route("sites.show", site.id)}
                                className="font-medium text-blue-600 hover:underline"
                            >
                                Details
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
                        </Td>
                    </Tr>
                ))}
            </>
        );

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <Table>
                <THead>
                    <Tr>
                        <Th>Server Name</Th>
                        <Th>Name</Th>
                        <Th>URL</Th>
                        <Th className="text-end">Actions</Th>
                    </Tr>
                </THead>
                <TBody>{siteRows}</TBody>
            </Table>
        </div>
    );
}
