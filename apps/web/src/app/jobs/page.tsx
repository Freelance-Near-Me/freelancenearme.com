import Link from "next/link";
import { listOpenJobs } from "@/actions/jobs";
import { JobCard } from "@/components/job-card";

export default async function JobsPage({
  searchParams,
}: {
  searchParams: Promise<{ q?: string }>;
}) {
  const { q } = await searchParams;
  const jobs = await listOpenJobs(q);

  return (
    <div className="mx-auto max-w-6xl px-4 py-12">
      <h1 className="font-serif text-4xl text-slate-900">Find jobs</h1>
      <p className="mt-2 text-slate-600">Browse open freelance projects</p>

      <form className="mt-8 flex gap-3" method="get">
        <input
          name="q"
          defaultValue={q}
          placeholder="Search jobs…"
          className="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm"
        />
        <button
          type="submit"
          className="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700"
        >
          Search
        </button>
      </form>

      <p className="mt-6 text-sm text-slate-500">{jobs.length} projects</p>
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
    </div>
  );
}
