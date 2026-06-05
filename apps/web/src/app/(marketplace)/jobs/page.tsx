import { listOpenJobs, type JobFilters } from "@/actions/jobs";
import { JobCard } from "@/components/job-card";
import { JobFilters as JobFiltersForm } from "@/components/job-filters";
import { PageShell } from "@/components/layout/page-shell";
import { EmptyState } from "@/components/ui/empty-state";
import { routes } from "@/lib/routes";

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
  };
}

export default async function JobsPage({
  searchParams,
}: {
  searchParams: Promise<Record<string, string | undefined>>;
}) {
  const sp = await searchParams;
  const jobs = await listOpenJobs(parseJobFilters(sp));

  return (
    <PageShell title="Find work" description="Browse open freelance projects" width="full">
      <JobFiltersForm searchParams={sp} />

      <p className="mt-6 text-sm text-slate-500">
        {jobs.length} {jobs.length === 1 ? "project" : "projects"}
      </p>

      {jobs.length === 0 ? (
        <div className="mt-8">
          <EmptyState
            title="No jobs match your search"
            description="Try different keywords or check back soon."
            action={{ label: "View all jobs", href: routes.jobs }}
          />
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
            />
          ))}
        </div>
      )}
    </PageShell>
  );
}
