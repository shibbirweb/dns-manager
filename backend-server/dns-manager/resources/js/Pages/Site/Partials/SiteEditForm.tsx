import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import { Transition } from "@headlessui/react";
import { useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { IServer, ISite } from "@/types";
import Select from "@/Components/Select";

export default function SiteEditForm({
    servers,
    site,
}: {
    servers: IServer[];
    site: ISite;
}) {
    const { data, setData, put, errors, processing, recentlySuccessful } =
        useForm<
            Omit<ISite, "id" | "server_id"> & {
                server_id: string | number;
            }
        >({
            name: site.name,
            server_id: site.server_id,
            url: site.url,
            admin_email: site.admin_email,
            site_path: site.site_path,
        });

    const onSubmitHandler: FormEventHandler = (e) => {
        e.preventDefault();

        put(route("sites.update", site.id));
    };

    return (
        <section>
            <header>
                <h2 className="text-lg font-medium text-gray-900">
                    Site Information
                </h2>

                <p className="mt-1 text-sm text-gray-600">
                    Update the information for your wordpress site.
                </p>
            </header>

            <form className="mt-6 space-y-6" onSubmit={onSubmitHandler}>
                <div>
                    <InputLabel htmlFor="server" value="Server" isRequired />

                    <Select
                        id="server"
                        isFocused
                        required
                        defaultValue={data.server_id}
                        onChange={(e) =>
                            setData(
                                "server_id",
                                e.target.value as unknown as number,
                            )
                        }
                    >
                        {servers.length === 0 && (
                            <option disabled value="">
                                No server available
                            </option>
                        )}
                        {servers.map((server) => (
                            <option key={server.id} value={server.id}>
                                {server.name} ({server.host}:{server.port})
                            </option>
                        ))}
                    </Select>

                    <InputError className="mt-2" message={errors.server_id} />
                </div>

                <div>
                    <InputLabel htmlFor="name" value="Name" isRequired />

                    <TextInput
                        id="name"
                        className="mt-1 block w-full"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        required
                        placeholder="Enter a name for your site"
                    />

                    <InputError className="mt-2" message={errors.name} />
                </div>

                <div>
                    <InputLabel htmlFor="url" value="URL" isRequired />

                    <TextInput
                        id="url"
                        className="mt-1 block w-full"
                        value={data.url}
                        onChange={(e) => setData("url", e.target.value)}
                        required
                        placeholder="Enter wordpress site url"
                    />

                    <InputError className="mt-2" message={errors.url} />
                </div>

                <div>
                    <InputLabel
                        htmlFor="admin-email"
                        value="Admin Email"
                        isRequired
                    />

                    <TextInput
                        id="admin-email"
                        type="email"
                        className="mt-1 block w-full"
                        value={data.admin_email}
                        onChange={(e) => setData("admin_email", e.target.value)}
                        required
                        placeholder="Enter wordpress site admn user email address"
                    />

                    <InputError className="mt-2" message={errors.admin_email} />
                </div>

                <div>
                    <InputLabel
                        htmlFor="site-path"
                        value="Site Path"
                        isRequired
                    />

                    <TextInput
                        id="site-path"
                        type="text"
                        className="mt-1 block w-full"
                        value={data.site_path}
                        onChange={(e) => setData("site_path", e.target.value)}
                        required
                        placeholder="Enter wordpress site path"
                    />

                    <InputError className="mt-2" message={errors.site_path} />
                </div>

                <div className="col-span-2 flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600">Saved.</p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
