import {
    FC,
    HTMLAttributes,
    TableHTMLAttributes,
    TdHTMLAttributes,
    ThHTMLAttributes,
} from "react";
import cn from "@/Utils/cn";

export const Table: FC<TableHTMLAttributes<HTMLTableElement>> = ({
    className,
    children,
    ...rest
}) => (
    <table
        className={cn("w-full text-left text-sm text-gray-500", className)}
        {...rest}
    >
        {children}
    </table>
);

export const THead: FC<HTMLAttributes<HTMLElement>> = ({
    className,
    children,
    ...rest
}) => (
    <thead
        className={cn("bg-gray-50 text-xs uppercase text-gray-700", className)}
        {...rest}
    >
        {children}
    </thead>
);

export const Tr: FC<HTMLAttributes<HTMLTableRowElement>> = ({
    children,
    ...rest
}) => <tr {...rest}>{children}</tr>;

export const Th: FC<ThHTMLAttributes<HTMLTableHeaderCellElement>> = ({
    className,
    children,
    ...rest
}) => (
    <th className={cn("px-6 py-3", className)} {...rest}>
        {children}
    </th>
);

export const TBody: FC<HTMLAttributes<HTMLTableSectionElement>> = ({
    className,
    children,
    ...rest
}) => (
    <tbody className={cn("divide-y divide-gray-200", className)} {...rest}>
        {children}
    </tbody>
);

export const Td: FC<TdHTMLAttributes<HTMLTableDataCellElement>> = ({
    className,
    children,
    ...rest
}) => (
    <td className={cn("px-6 py-4", className)} {...rest}>
        {children}
    </td>
);
