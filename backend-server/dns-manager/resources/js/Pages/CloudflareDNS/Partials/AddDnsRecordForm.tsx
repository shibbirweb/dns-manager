import { DnsRecord, DnsRecordType, ICloudflareDnsZone } from "@/types";
import PrimaryButton from "@/Components/PrimaryButton";
import Modal from "@/Components/Modal";
import React, { FormEvent, useState } from "react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import { Transition } from "@headlessui/react";
import { router, useForm } from "@inertiajs/react";
import Select from "@/Components/Select";

export default function AddDnsRecordForm({
    dnsRecordTypes,
    cloudflareDnsZones,
}: Readonly<{
    dnsRecordTypes: DnsRecordType[];
    cloudflareDnsZones: ICloudflareDnsZone[];
}>) {
    const [showModal, setShowModal] = useState(false);

    const {
        data,
        setData,
        reset,
        post,
        errors,
        clearErrors,
        processing,
        recentlySuccessful,
    } = useForm<DnsRecord>({
        zone_id: cloudflareDnsZones[0]?.id,
        type: "A",
        name: "",
        content: "",
    });

    const openModal = () => {
        setShowModal(true);
    };
    const closeModal = () => {
        setShowModal(false);
        reset();
        clearErrors();
    };

    const onFormSubmitHandler: (event: FormEvent<HTMLFormElement>) => void = (
        event,
    ) => {
        event.preventDefault();

        post(route("cloudflare-dns.store"), {
            onSuccess: () => {
                closeModal();
                router.reload();
            },
        });
    };

    return (
        <div className="flex items-center justify-end px-2 py-3">
            <PrimaryButton type="button" onClick={openModal}>
                Add Record
            </PrimaryButton>

            <Modal show={showModal} onClose={closeModal}>
                <form onSubmit={onFormSubmitHandler} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Add DNS Record
                    </h2>

                    <div className="mt-6">
                        <InputLabel htmlFor="Type" value="Type" isRequired />

                        <Select
                            id="type"
                            required
                            defaultValue={data.type}
                            onChange={(e) =>
                                setData("type", e.target.value as DnsRecordType)
                            }
                        >
                            {dnsRecordTypes.map((dnsRecordType) => (
                                <option
                                    key={dnsRecordType}
                                    value={dnsRecordType}
                                >
                                    {dnsRecordType}
                                </option>
                            ))}
                        </Select>

                        <InputError className="mt-2" message={errors.type} />
                    </div>

                    <div className="mt-6">
                        <InputLabel htmlFor="zone-id" value="Zone" isRequired />

                        <Select
                            id="zone-id"
                            required
                            defaultValue={data.zone_id}
                            onChange={(e) => setData("zone_id", e.target.value)}
                        >
                            {cloudflareDnsZones.map((cloudflareDnsZone) => (
                                <option
                                    key={cloudflareDnsZone.id}
                                    value={cloudflareDnsZone.id}
                                >
                                    {cloudflareDnsZone.name}
                                </option>
                            ))}
                        </Select>

                        <InputError className="mt-2" message={errors.type} />
                    </div>

                    <div className="mt-6">
                        <InputLabel htmlFor="name" value="Name" isRequired />

                        <TextInput
                            id="name"
                            className="mt-1 block w-full"
                            value={data.name}
                            onChange={(e) => setData("name", e.target.value)}
                            required
                            isFocused
                        />

                        <InputError className="mt-2" message={errors.name} />
                    </div>

                    <div className="mt-6">
                        <InputLabel
                            htmlFor="content"
                            value="Content"
                            isRequired
                        />

                        <TextInput
                            id="content"
                            className="mt-1 block w-full"
                            value={data.content}
                            onChange={(e) => setData("content", e.target.value)}
                            required
                            placeholder=""
                        />

                        <InputError className="mt-2" message={errors.content} />
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
        </div>
    );
}
