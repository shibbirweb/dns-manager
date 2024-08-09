import { Table, TBody, Td, Th, THead, Tr } from "@/Components/table";
import { IServer } from "@/types";
import { Link } from "@inertiajs/react";

export default function ServerListTable({
    servers = [],
}: Readonly<{
    servers: IServer[];
}>) {
    const serverRows =
        servers.length === 0 ? (
            <Tr>
                <Td colSpan={5} className="text-center">
                    No servers found
                </Td>
            </Tr>
        ) : (
            <>
                {servers.map((server) => (
                    <Tr key={server.id} className="bg-white hover:bg-gray-50">
                        <Th className="whitespace-nowrap py-4 font-medium text-gray-900">
                            {server.name}
                        </Th>
                        <Td>{server.host}</Td>
                        <Td>{server.port}</Td>
                        <Td>{server.username}</Td>
                        <Td className="flex flex-wrap items-center justify-center gap-2 text-right lg:justify-end">
                            <Link
                                href={route("servers.connect", server.id)}
                                className="font-medium text-blue-600 hover:underline"
                            >
                                Connect
                            </Link>
                            <Link
                                href={route("servers.edit", server.id)}
                                className="font-medium text-blue-600 hover:underline"
                            >
                                Edit
                            </Link>
                            <Link
                                href={route("servers.destroy", server.id)}
                                method="delete"
                                className="font-medium text-blue-600 hover:underline"
                                as="button"
                                type="button"
                                onClick={(e) => {
                                    if (
                                        !confirm(
                                            "Are you sure you want to remove this server?",
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
                        <Th>Host</Th>
                        <Th>Port</Th>
                        <Th>Username</Th>
                        <Th className="text-end">Actions</Th>
                    </Tr>
                </THead>
                <TBody>{serverRows}</TBody>
            </Table>
        </div>
    );
}
