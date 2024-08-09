import { IServer } from "@/types";
import TextInput from "@/Components/TextInput";
import { useEffect, useRef, useState } from "react";
import axios from "axios";

export default function ServerConnectWindow({
    server,
}: Readonly<{
    server: IServer;
}>) {
    const commandInputRef = useRef<HTMLInputElement>(null);
    const commandOutputRef = useRef<HTMLDivElement>(null);
    const [isProcessing, setIsProcessing] = useState<boolean>(false);
    const [commandOutput, setCommandOutput] = useState<string>("");
    const [commandInput, setCommandInput] = useState<string>("");

    useEffect(() => {
        commandOutputWindowScrollToBottom();
    }, [commandOutput]);
    const handleExecute = async () => {
        if (isProcessing) return;

        try {
            setCommandOutput((prev) => prev + "> " + commandInput + "\n");

            setCommandInput("");
            setIsProcessing(true);
            const response = await axios.post(
                `/internal-api/servers/${server.id}/execute-command`,
                {
                    command: commandInput,
                },
            );
            setCommandOutput(
                (prev) => prev + (response?.data?.data?.output ?? "") + "\n",
            );
        } catch (error) {
            alert("Error executing command");
        } finally {
            setIsProcessing(false);
        }
    };

    const commandOutputWindowScrollToBottom = () => {
        commandOutputRef.current?.scrollTo(
            0,
            commandOutputRef.current.scrollHeight,
        );
    };

    return (
        <div className="overflow-hidden bg-white shadow sm:rounded-lg">
            <div className="px-4 py-5 sm:px-6">
                <h3 className="text-lg font-medium leading-6 text-gray-900">
                    Server: {server.name} ({server.host}:{server.port})
                </h3>
                <p className="mt-1 max-w-2xl text-sm text-gray-500">
                    Execute commands on the server
                </p>
            </div>
            <div className="border-t border-gray-200">
                <div>
                    <div
                        ref={commandOutputRef}
                        className="h-64 overflow-y-scroll whitespace-pre-wrap bg-black p-4 font-mono text-green-400"
                    >
                        {commandOutput}
                    </div>

                    <TextInput
                        className="w-full rounded-t-none border-none bg-slate-800 p-4 font-mono text-green-400 focus:outline-0"
                        type="text"
                        value={commandInput}
                        ref={commandInputRef}
                        isFocused
                        onChange={(e) => setCommandInput(e.target.value)}
                        onKeyPress={(e) => {
                            if (e.key === "Enter") {
                                handleExecute();
                            }
                        }}
                    />
                </div>
            </div>
        </div>
    );
}
