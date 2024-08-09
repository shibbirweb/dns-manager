import { Link } from "@inertiajs/react";
import { IPaginationLink } from "@/types";
import { FC, HTMLAttributes } from "react";
import cn from "@/Utils/cn";

const Pagination: FC<
    HTMLAttributes<HTMLDivElement> & {
        links: IPaginationLink[];
    }
> = ({ links, className, ...rest }) => {
    function getClassName(active: boolean): string {
        if (active) {
            return "mr-1 mb-1 px-4 py-3 leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary bg-blue-700 text-white";
        } else {
            return "mr-1 mb-1 px-4 py-3 leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary";
        }
    }

    return (
        links.length > 3 && (
            <div
                className={cn(
                    "flex items-center justify-end text-xs",
                    className,
                )}
                {...rest}
            >
                <div className="mt-8 flex flex-wrap">
                    {links.map((link, key) =>
                        link.url === null ? (
                            <div
                                className="mb-1 mr-1 rounded border px-4 py-3 leading-4 text-gray-400"
                                key={key}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            ></div>
                        ) : (
                            <Link
                                key={key}
                                className={getClassName(link.active)}
                                href={link.url}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            ></Link>
                        ),
                    )}
                </div>
            </div>
        )
    );
};

export default Pagination;
