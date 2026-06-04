import { listOpenJobs } from "@/actions/jobs";
import { JobCard } from "@/components/job-card";
import { PageShell } from "@/components/layout/page-shell";
import { EmptyState } from "@/components/ui/empty-state";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { routes } from "@/lib/routes";

export default async function JobsPage({
  searchParams,
}: {
  searchParams: Promise<{ q?: string }>;
}) {
  const { q } = await searchParams;
  const jobs = await listOpenJobs(q);

  return (
    <PageShell title="Find work" description="Browse open freelance projects" width="full">
      <form className="flex flex-col gap-3 sm:flex-row" method="get">
        <Input name="q" defaultValue={q} placeholder="Search by title or keyword…" className="flex-1" />
        <Button type="submit" className="shrink-0 sm:px-8">
          Search
        </Button>
      </form>

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
              poster={job.poster}
              proposalCount={job._count.proposals}
            />
          ))}
        </div>
      )}
    </PageShell>
  );
}
