import { cn } from "@/lib/utils";

type BadgeVariant = "default" | "success" | "warning" | "info" | "muted" | "ochre";

const variants: Record<BadgeVariant, string> = {
  default: "bg-bone-50 text-ink-700 border border-bone-200",
  success: "chip-jade",
  warning: "bg-ochre-100 text-ochre-700 border border-ochre-500/35",
  info: "bg-bone-50 text-ink-700 border border-bone-200",
  muted: "bg-bone-200/60 text-ink-500",
  ochre: "chip-ochre",
};

export function Badge({
  children,
  variant = "default",
  className,
}: {
  children: React.ReactNode;
  variant?: BadgeVariant;
  className?: string;
}) {
  return (
    <span
      className={cn(
        "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize",
        variants[variant],
        className
      )}
    >
      {children}
    </span>
  );
}
