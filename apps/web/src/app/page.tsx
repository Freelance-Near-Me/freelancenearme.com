import Link from "next/link";
import { listOpenJobs } from "@/actions/jobs";
import { JobCard } from "@/components/job-card";
import { isDatabaseConfigured } from "@/lib/env";
import { routes } from "@/lib/routes";

export default async function HomePage() {
  const jobs = await listOpenJobs();
  const dbReady = isDatabaseConfigured();

  return (
    <div>
      {!dbReady && (
        <div className="border-b border-amber-200 bg-amber-50 px-4 py-3 text-center text-sm text-amber-900">
          Database is not connected. Set <code className="font-mono">DATABASE_URL</code> in your
          environment (see docs/ENVIRONMENT.md).
        </div>
      )}
      <section className="relative overflow-hidden bg-gradient-to-br from-blue-800 via-blue-600 to-slate-900 text-white">
        <div className="mx-auto max-w-6xl px-4 py-20 md:py-28">
          <p className="text-sm font-medium uppercase tracking-widest text-blue-100">
            Local & remote talent
          </p>
          <h1 className="mt-4 max-w-2xl font-serif text-4xl leading-tight md:text-5xl lg:text-6xl">
            Hire freelancers near you — or anywhere in the world
          </h1>
          <p className="mt-6 max-w-xl text-lg text-blue-100">
            Post a job, review proposals, send an offer, and manage contracts — one modern
            marketplace built for speed and trust.
          </p>
          <div className="mt-10 flex flex-wrap gap-4">
            <Link
              href={routes.signUp("client")}
              className="rounded-full bg-white px-6 py-3 text-sm font-semibold text-blue-700 shadow-lg hover:bg-blue-50"
            >
              I want to hire
            </Link>
            <Link
              href={routes.signUp("talent")}
              className="rounded-full border border-white/40 px-6 py-3 text-sm font-semibold hover:bg-white/10"
            >
              I want to find work
            </Link>
            <Link
              href={routes.jobs}
              className="rounded-full border border-white/40 px-6 py-3 text-sm font-semibold hover:bg-white/10"
            >
              Browse jobs
            </Link>
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-16">
        <div className="flex items-end justify-between">
          <h2 className="font-serif text-3xl text-slate-900">Open projects</h2>
          <Link href={routes.jobs} className="text-sm font-semibold text-blue-600 hover:text-blue-700">
            View all →
          </Link>
        </div>
        <div className="mt-8 grid gap-6 md:grid-cols-2">
          {jobs.slice(0, 4).map((job) => (
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
        {jobs.length === 0 && (
          <p className="text-slate-600">
            No jobs yet. Run <code className="rounded bg-slate-100 px-1">npm run db:seed</code> or post
            the first job.
          </p>
        )}
      </section>
    </div>
  );
}
