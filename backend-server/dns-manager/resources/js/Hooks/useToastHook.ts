import withReactContent from "sweetalert2-react-content";
import Swal from "sweetalert2";

const MySwal = withReactContent(Swal);

export default function useToastHook() {
    return (message: string, type: "success" | "error") => {
        MySwal.fire({
            title: type === "success" ? "Success!" : "Error!",
            text: message,
            icon: type,
            confirmButtonText: "Ok",
        });
    };
}
