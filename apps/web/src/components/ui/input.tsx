import { cn } from "@/lib/utils";

export function inputClassName(className?: string) {
  return cn(
    "w-full rounded-xl border border-bone-200 bg-white px-3 py-2.5 text-sm text-ink-900",
    "placeholder:text-ink-500 focus:border-ochre-500 focus:outline-none focus:ring-2 focus:ring-ochre-500/20",
    className
  );
}

export function Input({
  className,
  ...props
}: React.InputHTMLAttributes<HTMLInputElement>) {
  return <input className={inputClassName(className)} {...props} />;
}

export function Textarea({
  className,
  ...props
}: React.TextareaHTMLAttributes<HTMLTextAreaElement>) {
  return (
    <textarea
      className={cn(inputClassName(), "min-h-[5rem] resize-y", className)}
      {...props}
    />
  );
}

export function Select({
  className,
  children,
  ...props
}: React.SelectHTMLAttributes<HTMLSelectElement>) {
  return (
    <select className={inputClassName(className)} {...props}>
      {children}
    </select>
  );
}
