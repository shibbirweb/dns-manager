import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import { Transition } from "@headlessui/react";
import { useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { IServer } from "@/types";

export default function ServerEditForm({
    server,
}: Readonly<{
    server: IServer;
}>) {
    const { data, setData, patch, errors, processing, recentlySuccessful } =
        useForm<Omit<IServer, "id">>({
            name: server.name,
            host: server.host,
            port: server.port,
            username: server.username,
            password: server.password,
        });

    const onSubmitHandler: FormEventHandler = (e) => {
        e.preventDefault();

        patch(route("servers.update", server.id));
    };

    return (
        <section>
            <header>
                <h2 className="text-lg font-medium text-gray-900">
                    Server Information
                </h2>

                <p className="mt-1 text-sm text-gray-600">
                    Update the information for your server.
                </p>
            </header>

            <form
                className="mt-6 grid gap-6 lg:grid-cols-2"
                onSubmit={onSubmitHandler}
            >
                <div className="col-span-2">
                    <InputLabel htmlFor="name" value="Name" isRequired />

                    <TextInput
                        id="name"
                        className="mt-1 block w-full"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        required
                        isFocused
                        placeholder="Enter a name for your server"
                    />

                    <InputError className="mt-2" message={errors.name} />
                </div>

                <div>
                    <InputLabel htmlFor="host" value="Host" isRequired />

                    <TextInput
                        id="host"
                        className="mt-1 block w-full"
                        value={data.host}
                        onChange={(e) => setData("host", e.target.value)}
                        required
                        placeholder="Enter a hostname or IP address"
                    />

                    <InputError className="mt-2" message={errors.host} />
                </div>

                <div>
                    <InputLabel htmlFor="port" value="Port" isRequired />

                    <TextInput
                        id="port"
                        type="number"
                        className="mt-1 block w-full"
                        value={data.port}
                        onChange={(e) =>
                            setData("port", e.target.value as unknown as number)
                        }
                        required
                        placeholder="Enter a port number"
                    />

                    <InputError className="mt-2" message={errors.port} />
                </div>

                <div>
                    <InputLabel
                        htmlFor="username"
                        value="Username"
                        isRequired
                    />

                    <TextInput
                        id="username"
                        type="text"
                        className="mt-1 block w-full"
                        value={data.username}
                        onChange={(e) => setData("username", e.target.value)}
                        required
                        placeholder="Enter a username"
                    />

                    <InputError className="mt-2" message={errors.username} />
                </div>

                <div>
                    <InputLabel
                        htmlFor="password"
                        value="Password"
                        isRequired
                    />

                    <TextInput
                        id="password"
                        type="password"
                        className="mt-1 block w-full"
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        placeholder="Enter a password"
                        required
                    />

                    <InputError className="mt-2" message={errors.password} />
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
