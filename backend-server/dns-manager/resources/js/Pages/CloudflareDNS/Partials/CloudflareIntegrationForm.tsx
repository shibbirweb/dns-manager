import React, { FC, FormEvent, useState } from "react";
import PrimaryButton from "@/Components/PrimaryButton";
import Modal from "@/Components/Modal";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import { useForm } from "@inertiajs/react";
import { Transition } from "@headlessui/react";
import { ICloudflareIntegration } from "@/types";

const CloudflareIntegrationForm: FC = () => {
    const { data, setData, post, errors, processing, recentlySuccessful } =
        useForm<Omit<ICloudflareIntegration, "id">>({
            name: "",
            email: "",
            api_token: "",
        });

    const [showModal, setShowModal] = useState<boolean>(false);

    const openModal: () => void = () => setShowModal(true);
    const closeModal: () => void = () => setShowModal(false);

    const onFormSubmitHandler: (event: FormEvent<HTMLFormElement>) => void = (
        event,
    ) => {
        event.preventDefault();

        post(route("cloudflare-integration.store"), {
            onSuccess: () => closeModal(),
        });
    };

    return (
        <section>
            <PrimaryButton type="button" onClick={openModal}>
                Connect Cloudflare Account
            </PrimaryButton>

            <Modal show={showModal} onClose={closeModal}>
                <form onSubmit={onFormSubmitHandler} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Connect Cloudflare Account
                    </h2>
                    <div className="mt-6">
                        <InputLabel htmlFor="name" value="Name" isRequired />

                        <TextInput
                            id="name"
                            className="mt-1 block w-full"
                            value={data.name}
                            onChange={(e) => setData("name", e.target.value)}
                            required
                            placeholder="Enter the cloudflare account name"
                        />

                        <InputError className="mt-2" message={errors.name} />
                    </div>

                    <div className="mt-6">
                        <InputLabel htmlFor="email" value="Email" isRequired />

                        <TextInput
                            id="email"
                            className="mt-1 block w-full"
                            value={data.email}
                            onChange={(e) => setData("email", e.target.value)}
                            required
                            placeholder="Enter the cloudflare account email"
                        />

                        <InputError className="mt-2" message={errors.email} />
                    </div>

                    <div className="mt-6">
                        <InputLabel
                            htmlFor="api-key"
                            value="API Token"
                            isRequired
                        />

                        <TextInput
                            id="api-key"
                            className="mt-1 block w-full"
                            value={data.api_token}
                            onChange={(e) =>
                                setData("api_token", e.target.value)
                            }
                            required
                            placeholder="Enter the cloudflare account API token"
                        />

                        <InputError
                            className="mt-2"
                            message={errors.api_token}
                        />

                        <p className="mt-2">
                            <a
                                href="https://dash.cloudflare.com/profile/api-tokens"
                                className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                target="_blank"
                            >
                                Generate API Token
                            </a>
                        </p>
                    </div>

                    <div className="mt-6">
                        <PrimaryButton disabled={processing}>
                            Save
                        </PrimaryButton>

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
            </Modal>
        </section>
    );
};

export default CloudflareIntegrationForm;
