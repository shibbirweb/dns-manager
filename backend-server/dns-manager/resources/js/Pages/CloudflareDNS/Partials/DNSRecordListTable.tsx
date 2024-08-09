import { Table, TBody, Td, Th, THead, Tr } from "@/Components/table";
import { IDnsCloudflareRecord } from "@/types";

export default function DNSRecordListTable({
    cloudflareDnsRecords,
}: Readonly<{
    cloudflareDnsRecords: IDnsCloudflareRecord[];
}>) {
    const recordRows =
        cloudflareDnsRecords.length === 0 ? (
            <Tr>
                <Td colSpan={4} className="text-center text-gray-500">
                    No DNS records found
                </Td>
            </Tr>
        ) : (
            cloudflareDnsRecords.map((record) => {
                return (
                    <Tr key={record.id}>
                        <Td>{record.type}</Td>
                        <Td>{record.name}</Td>
                        <Td>{record.content}</Td>
                        <Td>{record.ttl == "1" ? "Auto" : record.ttl}</Td>
                    </Tr>
                );
            })
        );

    return (
        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <Table>
                <THead>
                    <Tr>
                        <Th>Type</Th>
                        <Th>Name</Th>
                        <Th>Content</Th>
                        <Th>TTL</Th>
                    </Tr>
                </THead>
                <TBody>{recordRows}</TBody>
            </Table>
        </div>
    );
}
