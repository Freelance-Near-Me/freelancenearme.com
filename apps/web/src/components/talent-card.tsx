import Link from "next/link";
import { VerificationTier } from "@fnm/database";
import { AvailabilityBadge } from "@/components/availability-badge";
import { StarRating } from "@/components/star-rating";
import { VerifiedHumanBadge } from "@/components/trust/verified-human-badge";
import { JobSuccessScore } from "@/components/trust/job-success-score";
import { Card, CardBody } from "@/components/ui/card";
import { formatDistanceMiles } from "@/lib/geocode";
import { routes } from "@/lib/routes";
import { Money } from "@/components/money/money";

type TalentCardProps = {
  username: string;
  firstName: string;
  lastName: string;
  headline?: string | null;
  hourlyRate?: { toString(): string } | null;
  availability?: string | null;
  verified?: boolean;
  verificationTier?: VerificationTier | null;
  jobSuccessScore?: number | null;
  skills?: { skill: { name: string; slug: string } }[];
  averageRating?: number;
  reviewCount?: number;
  city?: string | null;
  postcode?: string | null;
  distanceMiles?: number;
};

export function TalentCard({
  username,
  firstName,
  lastName,
  headline,
  hourlyRate,
  availability,
  verified,
  verificationTier,
  jobSuccessScore,
  skills = [],
  averageRating = 0,
  reviewCount = 0,
  city,
  postcode,
  distanceMiles,
}: TalentCardProps) {
  const location = [city, postcode].filter(Boolean).join(", ");
  const tier =
    verificationTier ??
    (verified ? VerificationTier.VERIFIED : VerificationTier.UNVERIFIED);

  return (
    <Card className="transition hover:border-ochre-500/30 hover:shadow-md">
      <CardBody>
        <div className="flex items-start justify-between gap-2">
          <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-ochre-100 text-sm font-semibold text-ochre-700">
            {firstName[0]}
            {lastName[0]}
          </div>
          <div className="flex flex-wrap justify-end gap-1">
            <VerifiedHumanBadge tier={tier} size="sm" />
            <AvailabilityBadge availability={availability} />
          </div>
        </div>

        <Link
          href={routes.freelancer(username)}
          className="mt-4 block font-semibold text-ink-900 hover:text-ochre-700"
        >
          {firstName} {lastName}
        </Link>
        <p className="text-sm text-ink-500">@{username}</p>

        {jobSuccessScore != null && (
          <div className="mt-2">
            <JobSuccessScore score={jobSuccessScore} size="sm" />
          </div>
        )}

        {reviewCount > 0 && (
          <div className="mt-2 flex items-center gap-2 text-sm">
            <StarRating rating={averageRating} />
            <span className="text-ink-500">
              {averageRating.toFixed(1)} ({reviewCount})
            </span>
          </div>
        )}

        {location && (
          <p className="mt-2 text-xs text-ink-500">
            {location}
            {distanceMiles != null && ` · ${formatDistanceMiles(distanceMiles)}`}
          </p>
        )}

        {headline && <p className="mt-2 line-clamp-2 text-sm text-ink-700">{headline}</p>}

        {hourlyRate != null && (
          <p className="mt-3 text-sm font-semibold">
            <Money amount={Number(hourlyRate)} size="sm" />
            <span className="text-ink-500">/hr</span>
          </p>
        )}

        {skills.length > 0 && (
          <div className="mt-3 flex flex-wrap gap-1">
            {skills.slice(0, 4).map((ts) => (
              <Link
                key={ts.skill.slug}
                href={routes.hire(ts.skill.slug)}
                className="rounded bg-bone-50 px-2 py-0.5 text-xs text-ink-700 hover:bg-ochre-100 hover:text-ochre-700"
              >
                {ts.skill.name}
              </Link>
            ))}
          </div>
        )}
      </CardBody>
    </Card>
  );
}
