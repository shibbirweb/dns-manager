import { FC, HTMLAttributes } from "react";
import cn from "@/Utils/cn";

const Container: FC<HTMLAttributes<HTMLDivElement>> = ({
    className,
    children,
    ...rest
}) => {
    return (
        <div
            className={cn("mx-auto max-w-7xl px-4 sm:px-6 lg:px-8", className)}
            {...rest}
        >
            {children}
        </div>
    );
};

export default Container;
