import Link from "next/link";
import { UserRole } from "@fnm/database";
import { getMyJobs } from "@/actions/jobs";
import { getMyProposals } from "@/actions/proposals";
import { getMyContracts } from "@/actions/contracts";
import { JobCard } from "@/components/job-card";
import { PageShell } from "@/components/layout/page-shell";
import { Card, CardBody } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { EmptyState } from "@/components/ui/empty-state";
import { Button } from "@/components/ui/button";
import { requireUser } from "@/lib/auth";
import { contractStatusLabel, proposalStatusLabel } from "@/lib/labels";
import { formatMoney } from "@/lib/format";
import { routes } from "@/lib/routes";

export default async function DashboardPage() {
  const user = await requireUser();
  const isClient = user.role === UserRole.CLIENT;

  return (
    <PageShell
      title={`Welcome back, ${user.firstName}`}
      description={`${isClient ? "Client" : "Talent"} · @${user.username}`}
      width="full"
      actions={
        <>
          <Link href={routes.profile}>
            <Button variant="secondary">Edit profile</Button>
          </Link>
          {isClient ? (
            <Link href={routes.postJob}>
              <Button>Post a job</Button>
            </Link>
          ) : (
            <>
              <Link href={routes.jobs}>
                <Button>Browse jobs</Button>
              </Link>
              <Link href={routes.payouts}>
                <Button variant="secondary">Payouts</Button>
              </Link>
            </>
          )}
        </>
      }
    >
      {isClient ? <ClientDashboard /> : <TalentDashboard />}
    </PageShell>
  );
}

async function ClientDashboard() {
  const [jobs, contracts] = await Promise.all([getMyJobs(), getMyContracts()]);

  return (
    <div className="space-y-10">
      <section>
        <div className="mb-4 flex items-center justify-between">
          <h2 className="text-lg font-semibold text-slate-900">Your jobs</h2>
          <Link href={routes.postJob} className="text-sm font-medium text-blue-600">
            Post new
          </Link>
        </div>
        {jobs.length === 0 ? (
          <EmptyState
            title="No jobs yet"
            description="Post your first project to start receiving proposals."
            action={{ label: "Post a job", href: routes.postJob }}
          />
        ) : (
          <div className="grid gap-6 md:grid-cols-2">
            {jobs.map((job) => (
              <div key={job.id}>
                {job.status === "DRAFT" && (
                  <Badge variant="muted" className="mb-2">
                    Draft
                  </Badge>
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
                <Link
                  href={routes.jobEdit(job.slug)}
                  className="mt-2 inline-block text-sm font-medium text-blue-600"
                >
                  Edit job
                </Link>
              </div>
            ))}
          </div>
        )}
      </section>
      <ContractsSection contracts={contracts} />
    </div>
  );
}

async function TalentDashboard() {
  const [proposals, contracts] = await Promise.all([getMyProposals(), getMyContracts()]);

  return (
    <div className="space-y-10">
      <section>
        <h2 className="mb-4 text-lg font-semibold text-slate-900">Your proposals</h2>
        {proposals.length === 0 ? (
          <EmptyState
            title="No proposals yet"
            description="Browse open jobs and submit your first proposal."
            action={{ label: "Find jobs", href: routes.jobs }}
          />
        ) : (
          <ul className="space-y-3">
            {proposals.map((p) => (
              <li key={p.id}>
                <Card>
                  <CardBody className="flex flex-wrap items-center justify-between gap-3">
                    <div>
                      <Link
                        href={routes.job(p.job.slug)}
                        className="font-medium text-blue-600 hover:underline"
                      >
                        {p.job.title}
                      </Link>
                      <p className="mt-1 text-sm text-slate-600">
                        {formatMoney(Number(p.bidAmount))} · {p.deliveryDays} days
                      </p>
                    </div>
                    <Badge variant={p.status === "ACCEPTED" ? "success" : "default"}>
                      {proposalStatusLabel(p.status)}
                    </Badge>
                  </CardBody>
                </Card>
              </li>
            ))}
          </ul>
        )}
      </section>
      <ContractsSection contracts={contracts} />
    </div>
  );
}

function ContractsSection({
  contracts,
}: {
  contracts: Awaited<ReturnType<typeof getMyContracts>>;
}) {
  return (
    <section>
      <h2 className="mb-4 text-lg font-semibold text-slate-900">Contracts</h2>
      {contracts.length === 0 ? (
        <EmptyState title="No contracts yet" description="Contracts appear after you send or accept an offer." />
      ) : (
        <ul className="space-y-3">
          {contracts.map((c) => (
            <li key={c.id}>
              <Link href={routes.contract(c.id)}>
                <Card className="transition hover:border-blue-200 hover:shadow-md">
                  <CardBody className="flex flex-wrap items-center justify-between gap-3">
                    <div>
                      <p className="font-medium text-slate-900">{c.title}</p>
                      <p className="mt-1 text-sm text-slate-600">{formatMoney(Number(c.amount))}</p>
                    </div>
                    <Badge variant={c.status === "ACTIVE" ? "success" : "info"}>
                      {contractStatusLabel(c.status)}
                    </Badge>
                  </CardBody>
                </Card>
              </Link>
            </li>
          ))}
        </ul>
      )}
    </section>
  );
}
