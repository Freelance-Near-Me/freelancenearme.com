import { cn } from "@/lib/utils";

export type MoneyTone = "auto" | "jade" | "ink" | "ochre" | "muted";
export type MoneySize = "sm" | "md" | "lg" | "xl";

interface MoneyProps {
  /** Dollar amount (not cents) */
  amount: number;
  currency?: string;
  locale?: string;
  sign?: "auto" | "always" | "never";
  tone?: MoneyTone;
  size?: MoneySize;
  className?: string;
  ariaLabel?: string;
}

const TONE_CLASS: Record<Exclude<MoneyTone, "auto">, string> = {
  jade: "money-tone-jade",
  ink: "money-tone-ink",
  ochre: "money-tone-ochre",
  muted: "money-tone-muted",
};

const SIZE_CLASS: Record<MoneySize, string> = {
  sm: "money-size-sm",
  md: "money-size-md",
  lg: "money-size-lg",
  xl: "money-size-xl",
};

export function Money({
  amount,
  currency = "USD",
  locale = "en-US",
  sign = "auto",
  tone = "auto",
  size = "md",
  className,
  ariaLabel,
}: MoneyProps) {
  const value = amount || 0;
  const abs = Math.abs(value);

  const formatter = new Intl.NumberFormat(locale, {
    style: "currency",
    currency,
    currencyDisplay: "narrowSymbol",
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  });

  const body = formatter.format(abs);
  const isNegative = value < 0;
  const isPositive = value > 0;

  let prefix = "";
  if (sign === "always" && isPositive) prefix = "+";
  if (isNegative) prefix = "-";

  const resolvedTone: Exclude<MoneyTone, "auto"> =
    tone === "auto" ? (isNegative ? "jade" : "ink") : tone;

  const display = `${prefix}${body}`;

  return (
    <span
      className={cn("money", TONE_CLASS[resolvedTone], SIZE_CLASS[size], className)}
      aria-label={ariaLabel ?? display}
    >
      {display}
    </span>
  );
}
