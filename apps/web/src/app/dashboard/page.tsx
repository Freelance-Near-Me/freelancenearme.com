import Link from "next/link";
import { UserRole } from "@fnm/database";
import { getMyJobs } from "@/actions/jobs";
import { getMyProposals } from "@/actions/proposals";
import { getMyContracts } from "@/actions/contracts";
import { requireUser } from "@/lib/auth";
import { JobCard } from "@/components/job-card";
import { formatMoney } from "@/lib/utils";

export default async function DashboardPage() {
  const user = await requireUser();

  return (
    <div className="mx-auto max-w-6xl px-4 py-12">
      <h1 className="font-serif text-4xl text-slate-900">
        Hello, {user.firstName}
      </h1>
      <p className="mt-2 capitalize text-slate-600">
        {user.role === UserRole.CLIENT ? "Client" : "Talent"} account · @{user.username}
      </p>

      <div className="mt-8 flex flex-wrap gap-3">
        <Link
          href="/profile"
          className="rounded-full border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
        >
          Edit profile
        </Link>
        {user.role === UserRole.CLIENT && (
          <Link
            href="/jobs/post"
            className="rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
          >
            Post a job
          </Link>
        )}
        {user.role === UserRole.TALENT && (
          <>
            <Link
              href="/jobs"
              className="rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
            >
              Browse jobs
            </Link>
            <Link
              href="/settings/payouts"
              className="rounded-full border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
            >
              Payout settings
            </Link>
          </>
        )}
      </div>

      {user.role === UserRole.CLIENT && <ClientDashboard />}
      {user.role === UserRole.TALENT && <TalentDashboard />}
    </div>
  );
}

async function ClientDashboard() {
  const jobs = await getMyJobs();
  const contracts = await getMyContracts();

  return (
    <div className="mt-12 space-y-12">
      <section>
        <h2 className="text-xl font-semibold">Your jobs</h2>
        <div className="mt-6 grid gap-6 md:grid-cols-2">
          {jobs.map((job) => (
            <div key={job.id}>
              {job.status === "DRAFT" && (
                <span className="mb-2 inline-block rounded-full bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-700">
                  Draft
                </span>
              )}
              <JobCard
                slug={job.slug}
                title={job.title}
                description={job.description}
                budgetMin={job.budgetMin}
                budgetMax={job.budgetMax}
                billingMode={job.billingMode}
                environment={job.environment}
                proposalCount={job._count.proposals}
              />
              <Link href={`/jobs/${job.slug}/edit`} className="mt-2 inline-block text-sm text-blue-600">
                Edit
              </Link>
            </div>
          ))}
          {jobs.length === 0 && <p className="text-slate-600">No jobs posted yet.</p>}
        </div>
      </section>
      <ContractsList contracts={contracts} />
    </div>
  );
}

async function TalentDashboard() {
  const proposals = await getMyProposals();
  const contracts = await getMyContracts();

  return (
    <div className="mt-12 space-y-12">
      <section>
        <h2 className="text-xl font-semibold">Your proposals</h2>
        <ul className="mt-4 space-y-3">
          {proposals.map((p) => (
            <li key={p.id} className="rounded-xl border border-slate-200 bg-white p-4">
              <Link href={`/jobs/${p.job.slug}`} className="font-medium text-blue-600">
                {p.job.title}
              </Link>
              <p className="text-sm text-slate-500 capitalize">
                {p.status.toLowerCase()} · {formatMoney(Number(p.bidAmount))}
              </p>
            </li>
          ))}
          {proposals.length === 0 && <p className="text-slate-600">No proposals yet.</p>}
        </ul>
      </section>
      <ContractsList contracts={contracts} />
    </div>
  );
}

function ContractsList({
  contracts,
}: {
  contracts: Awaited<ReturnType<typeof getMyContracts>>;
}) {
  return (
    <section>
      <h2 className="text-xl font-semibold">Contracts</h2>
      <ul className="mt-4 space-y-3">
        {contracts.map((c) => (
          <li key={c.id} className="rounded-xl border border-slate-200 bg-white p-4">
            <Link href={`/contracts/${c.id}`} className="font-medium text-blue-600">
              {c.title}
            </Link>
            <p className="text-sm text-slate-500 capitalize">
              {c.status.toLowerCase().replace(/_/g, " ")} · {formatMoney(Number(c.amount))}
            </p>
          </li>
        ))}
        {contracts.length === 0 && <p className="text-slate-600">No contracts yet.</p>}
      </ul>
    </section>
  );
}
