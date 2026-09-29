import Link from "next/link";
import { CheckCircle2, MapPin, Video } from "lucide-react";
import { VerificationTier } from "@fnm/database";
import { routes } from "@/lib/routes";

export type PortraitTalent = {
  username?: string;
  firstName: string;
  lastName: string;
  title?: string | null;
  city?: string | null;
  country?: string | null;
  avatarUrl?: string | null;
  verificationTier?: VerificationTier | null;
  verified?: boolean;
  example?: boolean;
};

function initials(first?: string, last?: string) {
  return `${(first?.[0] ?? "").toUpperCase()}${(last?.[0] ?? "").toUpperCase()}`;
}

function locationLabel(talent: PortraitTalent) {
  return [talent.city, talent.country].filter(Boolean).join(", ") || "United States";
}

export function PortraitCard({ talent }: { talent: PortraitTalent }) {
  const tier = talent.example ? null : talent.verificationTier;
  const isTop = tier === VerificationTier.TOP_RATED;
  const isVerified =
    !talent.example &&
    (tier === VerificationTier.VERIFIED || tier === VerificationTier.TOP_RATED || talent.verified);
  const stamp = isTop ? "VH+" : isVerified ? "VH" : null;

  const inner = (
    <article className="portrait-card flex flex-col gap-3 p-4">
      <div className="flex items-start gap-3">
        <div className="relative grid h-14 w-14 flex-shrink-0 place-items-center overflow-hidden rounded-full bg-jade-700 text-[15px] font-semibold text-bone">
          {talent.avatarUrl ? (
            // eslint-disable-next-line @next/next/no-img-element
            <img
              src={talent.avatarUrl}
              alt={`${talent.firstName} ${talent.lastName}`}
              className="h-full w-full object-cover"
            />
          ) : (
            initials(talent.firstName, talent.lastName)
          )}
        </div>
        <div className="min-w-0">
          <p className="truncate text-[15px] font-semibold text-ink-900">
            {talent.firstName} {talent.lastName}
          </p>
          <p className="truncate text-[13px] text-ink-500">
            {talent.title ?? "Verified freelancer"}
          </p>
        </div>
      </div>

      {stamp ? <div className="portrait-stamp">{stamp}</div> : null}

      <div className="flex flex-wrap items-center gap-x-3 gap-y-1.5 text-[12.5px] text-ink-700">
        <span className="inline-flex items-center gap-1">
          <MapPin className="h-3.5 w-3.5 text-ink-500" aria-hidden />
          {locationLabel(talent)}
        </span>
      </div>

      <div className="flex flex-wrap gap-1.5 pt-1">
        {talent.example && <span className="badge-elite">Example</span>}
        {isVerified && (
          <span className="badge-eucalyptus">
            <CheckCircle2 className="h-3 w-3" aria-hidden /> Payouts set up
          </span>
        )}
        {isTop && (
          <span className="badge-elite">
            <Video className="h-3 w-3" aria-hidden /> Top rated
          </span>
        )}
        {tier === VerificationTier.EMAIL && (
          <span className="badge-elite">
            <CheckCircle2 className="h-3 w-3" aria-hidden /> Email verified
          </span>
        )}
      </div>
    </article>
  );

  if (talent.username) {
    return (
      <Link href={routes.freelancer(talent.username)} className="block">
        {inner}
      </Link>
    );
  }

  return inner;
}
