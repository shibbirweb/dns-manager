import { LabelHTMLAttributes } from "react";

interface Props extends LabelHTMLAttributes<HTMLLabelElement> {
    value?: string;
    isRequired?: boolean;
}

export default function InputLabel({
    value,
    isRequired,
    className = "",
    children,
    ...props
}: Readonly<Props>) {
    return (
        <label
            {...props}
            className={`block text-sm font-medium text-gray-700 ` + className}
        >
            {value ?? children}
            {isRequired && <span className="text-red-500">*</span>}
        </label>
    );
}
