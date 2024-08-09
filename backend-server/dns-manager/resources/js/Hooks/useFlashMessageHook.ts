import { useEffect } from "react";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
import { usePage } from "@inertiajs/react";
import { PageProps } from "@/types";

const MySwal = withReactContent(Swal);
const useFlashMessageHook = () => {
    const { flash } = usePage<PageProps>().props;
    useEffect(() => {
        if (flash.success) {
            MySwal.fire({
                title: "Success!",
                text: flash.success,
                icon: "success",
                confirmButtonText: "Ok",
            });
        }

        if (flash.error) {
            MySwal.fire({
                title: "Error!",
                text: flash.error,
                icon: "error",
                confirmButtonText: "Ok",
            });
        }
    }, [flash]);
};

export default useFlashMessageHook;
