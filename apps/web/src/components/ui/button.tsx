import Link from "next/link";
import { cn } from "@/lib/utils";

type Variant = "primary" | "secondary" | "ghost" | "danger" | "ink" | "ochre" | "quiet";

const variants: Record<Variant, string> = {
  primary: "btn-ink",
  ink: "btn-ink",
  ochre: "btn-ochre",
  secondary: "btn-quiet",
  quiet: "btn-quiet",
  ghost: "text-ink-700 hover:bg-ink-900/5 rounded-lg px-4 py-2",
  danger: "bg-red-600 text-white hover:bg-red-700 rounded-lg px-4 py-2",
};

export function Button({
  className,
  variant = "primary",
  ...props
}: React.ButtonHTMLAttributes<HTMLButtonElement> & { variant?: Variant }) {
  const isUtility = variant === "primary" || variant === "ink" || variant === "ochre" || variant === "secondary" || variant === "quiet";
  return (
    <button
      className={cn(
        "inline-flex items-center justify-center text-sm font-semibold transition disabled:opacity-50",
        !isUtility && "rounded-full px-4 py-2",
        variants[variant],
        className
      )}
      {...props}
    />
  );
}

export function ButtonLink({
  href,
  className,
  variant = "primary",
  children,
  ...props
}: React.ComponentProps<typeof Link> & { variant?: Variant }) {
  const isUtility = variant === "primary" || variant === "ink" || variant === "ochre" || variant === "secondary" || variant === "quiet";
  return (
    <Link
      href={href}
      className={cn(
        "inline-flex items-center justify-center text-sm font-semibold transition",
        !isUtility && "rounded-full px-4 py-2",
        variants[variant],
        className
      )}
      {...props}
    >
      {children}
    </Link>
  );
}
