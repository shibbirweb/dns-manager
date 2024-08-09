export interface IUser {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: IUser;
    };
    flash: {
        success: string | null;
        error: string | null;
    }
};

export interface IPaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface IPaginatedData<T> {
    current_page: number;
    data: T[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: IPaginationLink[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

export interface IServer {
    id: number;
    name: string;
    host: string;
    port: number;
    username: string;
    password: string;
}

export interface ISite {
    id: number;
    server_id: number;
    name: string;
    url: string;
    site_path: string;
    admin_email: string;
    secret_key?: string,

    server?: IServer;
}

export interface ICloudflareIntegration{
    id: number;
    name: string;
    email: string;
    api_token: string;
}

export interface IDnsCloudflareRecord {
    id: string;
    zoneId: string;
    zoneName: string;
    name: string;
    type: string;
    content: string;
    proxied: boolean;
    proxiable: boolean;
    ttl: string;
}

export interface ICloudflareDnsZone {
    id: string;
    name: string;
}

export type DnsRecordType = 'A' | 'TXT' | 'CNAME'

export type DnsRecord = {
    zone_id: string;
    type: DnsRecordType,
    content: string;
    name: string;
}
