/** Platform fee taken from a milestone when the client releases payment. */

export function platformFeePercent(): number {
  const n = Number(process.env.PLATFORM_FEE_PERCENT ?? process.env.NEXT_PUBLIC_PLATFORM_FEE_PERCENT ?? "10");
  return Number.isFinite(n) && n >= 0 && n <= 50 ? n : 10;
}

export function platformFeeSummary(): string {
  const pct = platformFeePercent();
  return `The platform fee is ${pct}% of each milestone. It is deducted when the client releases payment to the freelancer. Clients are not charged a separate fee.`;
}
