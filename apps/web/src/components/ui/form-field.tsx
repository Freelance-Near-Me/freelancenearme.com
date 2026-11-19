import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { NativeSelect } from "@/components/ui/native-select";
import { Textarea } from "@/components/ui/textarea";

type FormFieldProps = {
  label: string;
  name: string;
  defaultValue?: string;
  type?: string;
  required?: boolean;
  placeholder?: string;
  as?: "input" | "textarea" | "select";
  rows?: number;
  children?: React.ReactNode;
};

/** Convenience labeled control for server-action forms. */
export function FormField({
  label,
  name,
  defaultValue,
  type = "text",
  required,
  placeholder,
  as = "input",
  rows = 4,
  children,
}: FormFieldProps) {
  return (
    <div className="grid w-full gap-1.5">
      <Label htmlFor={name}>{label}</Label>
      {as === "textarea" ? (
        <Textarea
          id={name}
          name={name}
          defaultValue={defaultValue}
          required={required}
          placeholder={placeholder}
          rows={rows}
        />
      ) : as === "select" ? (
        <NativeSelect
          id={name}
          name={name}
          defaultValue={defaultValue}
          required={required}
        >
          {children}
        </NativeSelect>
      ) : (
        <Input
          id={name}
          name={name}
          type={type}
          defaultValue={defaultValue}
          required={required}
          placeholder={placeholder}
        />
      )}
    </div>
  );
}

/** Back-compat alias used by existing form pages. */
export { FormField as Field };
