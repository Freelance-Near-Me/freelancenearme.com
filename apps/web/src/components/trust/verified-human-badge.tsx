import { CircleDashed, Crown, Shield, ShieldCheck } from "lucide-react";
import { VerificationTier } from "@fnm/database";
import { cn } from "@/lib/utils";

type Tier = VerificationTier;

interface VerifiedHumanBadgeProps {
  tier?: Tier | null;
  size?: "sm" | "md" | "lg";
  withLabel?: boolean;
  className?: string;
}

const TIER_META: Record<
  Tier,
  {
    label: string;
    blurb: string;
    icon: typeof Shield;
    className: string;
  }
> = {
  UNVERIFIED: {
    label: "Unverified",
    blurb: "This freelancer has not completed verification yet.",
    icon: CircleDashed,
    className: "chip",
  },
  EMAIL: {
    label: "Email verified",
    blurb: "We confirmed they own a working email address.",
    icon: Shield,
    className: "chip",
  },
  VERIFIED: {
    label: "Verified",
    blurb: "Profile verified and payout setup complete.",
    icon: ShieldCheck,
    className: "chip-jade",
  },
  TOP_RATED: {
    label: "Top rated",
    blurb: "Excellent job success score with multiple completed contracts.",
    icon: Crown,
    className: "chip-jade",
  },
};

const SIZE_CLASS = {
  sm: "text-[10px] px-2 py-0.5",
  md: "text-[11px]",
  lg: "text-xs px-3 py-1.5",
};

export function VerifiedHumanBadge({
  tier = VerificationTier.UNVERIFIED,
  size = "md",
  withLabel = true,
  className,
}: VerifiedHumanBadgeProps) {
  if (!tier || tier === VerificationTier.UNVERIFIED) return null;

  const meta = TIER_META[tier];
  const Icon = meta.icon;

  return (
    <span
      className={cn("chip", meta.className, SIZE_CLASS[size], className)}
      title={meta.blurb}
    >
      <Icon className={size === "sm" ? "h-3 w-3" : "h-3.5 w-3.5"} aria-hidden />
      {withLabel ? meta.label : null}
    </span>
  );
}

/** @deprecated Use VerifiedHumanBadge with verificationTier */
export function VerifiedBadge() {
  return <VerifiedHumanBadge tier={VerificationTier.VERIFIED} />;
}
