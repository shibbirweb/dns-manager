import {
    forwardRef,
    SelectHTMLAttributes,
    useEffect,
    useImperativeHandle,
    useRef,
} from "react";
import cn from "@/Utils/cn";

export default forwardRef(function TextInput(
    {
        className = "",
        isFocused = false,
        ...props
    }: SelectHTMLAttributes<HTMLSelectElement> & { isFocused?: boolean },
    ref,
) {
    const localRef = useRef<HTMLSelectElement>(null);

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }));

    useEffect(() => {
        if (isFocused) {
            localRef.current?.focus();
        }
    }, []);

    return (
        <select
            {...props}
            className={cn(
                "w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500",
                className,
            )}
            ref={localRef}
        >
            {props.children}
        </select>
    );
});
