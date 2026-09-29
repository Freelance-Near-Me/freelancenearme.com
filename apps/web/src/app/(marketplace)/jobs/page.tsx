import type { Metadata } from "next";
import { listOpenJobs, type JobFilters } from "@/actions/jobs";
import { getCurrentUser } from "@/lib/auth";
import { JobCard } from "@/components/job-card";
import { JobFilters as JobFiltersForm } from "@/components/job-filters";
import { SaveSearchForm } from "@/components/save-search-form";
import { WaitlistForm } from "@/components/waitlist-form";
import { PageShell } from "@/components/layout/page-shell";
import { EmptyState } from "@/components/ui/empty-state";
import { routes } from "@/lib/routes";

export const revalidate = 3600;

export const metadata: Metadata = {
  title: "Find work",
  description: "Browse open freelance projects in the US. Budgets are shown as a fixed total or an hourly rate.",
};

function parseJobFilters(sp: Record<string, string | undefined>): JobFilters {
  return {
    q: sp.q,
    category: sp.category,
    environment: sp.environment as JobFilters["environment"],
    billingMode: sp.billingMode as JobFilters["billingMode"],
    experienceLevel: sp.experienceLevel as JobFilters["experienceLevel"],
    skill: sp.skill,
    minBudget: sp.minBudget ? Number(sp.minBudget) : undefined,
    maxBudget: sp.maxBudget ? Number(sp.maxBudget) : undefined,
    featured: sp.featured === "1" || sp.featured === "on",
    urgent: sp.urgent === "1" || sp.urgent === "on",
    nearPostcode: sp.nearPostcode,
    radiusMiles: sp.radiusMiles ? Number(sp.radiusMiles) : undefined,
  };
}

export default async function JobsPage({
  searchParams,
}: {
  searchParams: Promise<Record<string, string | undefined>>;
}) {
  const sp = await searchParams;
  const filters = parseJobFilters(sp);
  const jobs = await listOpenJobs(filters);
  const user = await getCurrentUser();
  const filtersJson = JSON.stringify(filters);

  return (
    <PageShell title="Find work" description="Browse open freelance projects" width="full">
      <JobFiltersForm searchParams={sp} />

      <p className="mt-6 text-sm text-slate-500">
        {jobs.length} {jobs.length === 1 ? "project" : "projects"}
      </p>

      {jobs.length === 0 ? (
        <div className="mt-8 space-y-6">
          <EmptyState
            title={
              sp.q || sp.category || sp.nearPostcode || sp.skill
                ? "No jobs match your search"
                : "No open projects yet"
            }
            description={
              sp.q || sp.category || sp.nearPostcode || sp.skill
                ? "Try a wider radius or clear the filters. You can leave your email to hear when a project is posted nearby."
                : "When a client posts a project, it will show up here."
            }
            action={
              sp.q || sp.category || sp.nearPostcode || sp.skill
                ? { label: "View all jobs", href: routes.jobs }
                : { label: "Post a project", href: routes.postJob }
            }
          />
          {user ? (
            <SaveSearchForm filtersJson={filtersJson} />
          ) : (
            <WaitlistForm defaultPostcode={sp.nearPostcode} />
          )}
        </div>
      ) : (
        <div className="mt-8 grid gap-6 md:grid-cols-2">
          {jobs.map((job) => (
            <JobCard
              key={job.id}
              slug={job.slug}
              title={job.title}
              description={job.description}
              budgetMin={job.budgetMin}
              budgetMax={job.budgetMax}
              billingMode={job.billingMode}
              environment={job.environment}
              featured={job.featured}
              urgent={job.urgent}
              category={job.category}
              poster={job.poster}
              proposalCount={job._count.proposals}
              location={{ city: job.city, country: job.country, postcode: job.postcode }}
              distanceMiles={job.distanceMiles}
            />
          ))}
        </div>
      )}
    </PageShell>
  );
}
