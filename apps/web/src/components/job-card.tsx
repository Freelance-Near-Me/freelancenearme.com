import Link from "next/link";
import { formatMoney } from "@/lib/utils";

type JobCardProps = {
  slug: string;
  title: string;
  description: string;
  budgetMin: { toString(): string };
  budgetMax: { toString(): string };
  billingMode: string;
  environment: string;
  featured?: boolean;
  poster?: { firstName: string; lastName: string; city?: string | null; country?: string | null };
  proposalCount?: number;
};

export function JobCard({
  slug,
  title,
  description,
  budgetMin,
  budgetMax,
  billingMode,
  environment,
  featured,
  poster,
  proposalCount,
}: JobCardProps) {
  const min = parseFloat(budgetMin.toString());
  const max = parseFloat(budgetMax.toString());
  const suffix = billingMode === "HOURLY" ? " / hr" : "";

  return (
    <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-200 hover:shadow-md">
      {featured && (
        <span className="mb-2 inline-block rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">
          Featured
        </span>
      )}
      <Link href={`/jobs/${slug}`} className="text-lg font-semibold text-slate-900 hover:text-blue-600">
        {title}
      </Link>
      <p className="mt-2 line-clamp-2 text-sm text-slate-600">{description}</p>
      <div className="mt-4 flex flex-wrap items-center justify-between gap-2 text-sm">
        <span className="font-semibold text-slate-900">
          {formatMoney(min)} – {formatMoney(max)}
          {suffix}
        </span>
        <span className="capitalize text-slate-500">{environment.toLowerCase()}</span>
      </div>
      {poster && (
        <p className="mt-3 text-xs text-slate-500">
          {poster.firstName} {poster.lastName}
          {[poster.city, poster.country].filter(Boolean).length > 0 &&
            ` · ${[poster.city, poster.country].filter(Boolean).join(", ")}`}
          {proposalCount != null && ` · ${proposalCount} proposals`}
        </p>
      )}
    </article>
  );
}
