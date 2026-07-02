import Link from "next/link";
import { Card, CardBody } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Money } from "@/components/money/money";
import { formatDistanceMiles } from "@/lib/geocode";
import { routes } from "@/lib/routes";

type JobCardProps = {
  slug: string;
  title: string;
  description: string;
  budgetMin: { toString(): string };
  budgetMax: { toString(): string };
  billingMode: string;
  environment: string;
  featured?: boolean;
  urgent?: boolean;
  category?: { name: string; slug: string } | null;
  poster?: { firstName: string; lastName: string; city?: string | null; country?: string | null };
  proposalCount?: number;
  location?: { city?: string | null; country?: string | null; postcode?: string | null };
  distanceMiles?: number;
};

function formatBudget(
  budgetMin: { toString(): string },
  budgetMax: { toString(): string },
  billingMode: string
) {
  const min = Number(budgetMin);
  const max = Number(budgetMax);
  const suffix = billingMode === "HOURLY" ? "/hr" : "";
  if (min === max) {
    return (
      <>
        <Money amount={min} size="sm" />
        {suffix}
      </>
    );
  }
  return (
    <>
      <Money amount={min} size="sm" />
      {" – "}
      <Money amount={max} size="sm" />
      {suffix}
    </>
  );
}

export function JobCard({
  slug,
  title,
  description,
  budgetMin,
  budgetMax,
  billingMode,
  environment,
  featured,
  urgent,
  category,
  poster,
  proposalCount,
  location: jobLocation,
  distanceMiles,
}: JobCardProps) {
  const locationText = [jobLocation?.postcode, jobLocation?.city, jobLocation?.country]
    .filter(Boolean)
    .join(", ");

  return (
    <Card className="transition hover:border-ochre-500/30 hover:shadow-md">
      <CardBody>
        <div className="mb-3 flex flex-wrap gap-2">
          {featured && <Badge variant="ochre">Featured</Badge>}
          {urgent && <Badge variant="warning">Urgent</Badge>}
          {category && (
            <Link href={routes.category(category.slug)}>
              <Badge variant="muted">{category.name}</Badge>
            </Link>
          )}
        </div>
        <Link
          href={routes.job(slug)}
          className="text-lg font-semibold text-ink-900 hover:text-ochre-700"
        >
          {title}
        </Link>
        <p className="mt-2 line-clamp-2 text-sm text-ink-600">{description}</p>
        <div className="mt-4 flex flex-wrap items-center justify-between gap-2 text-sm">
          <span className="font-semibold">{formatBudget(budgetMin, budgetMax, billingMode)}</span>
          <span className="capitalize text-ink-500">{environment.toLowerCase()}</span>
        </div>
        <p className="mt-3 text-xs text-ink-500">
          {poster && (
            <>
              {poster.firstName} {poster.lastName}
              {proposalCount != null && ` · ${proposalCount} proposals`}
            </>
          )}
          {locationText && (
            <span className={poster ? " block" : ""}>
              {locationText}
              {distanceMiles != null && ` · ${formatDistanceMiles(distanceMiles)}`}
            </span>
          )}
        </p>
      </CardBody>
    </Card>
  );
}
