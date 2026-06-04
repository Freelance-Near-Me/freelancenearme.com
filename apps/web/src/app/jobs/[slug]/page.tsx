import Link from "next/link";
import { notFound } from "next/navigation";
import { JobStatus, UserRole } from "@fnm/database";
import { getJobBySlug } from "@/actions/jobs";
import { getCurrentUser } from "@/lib/auth";
import { formatMoney } from "@/lib/utils";
import { ProposalForm } from "@/components/proposal-form";
import { ProposalInbox } from "@/components/proposal-inbox";

export default async function JobDetailPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const job = await getJobBySlug(slug);
  if (!job) notFound();

  const user = await getCurrentUser();
  const isOwner = user?.id === job.posterId;
  const canPropose =
    user?.role === UserRole.TALENT && job.status === JobStatus.OPEN && !isOwner;
  const alreadyProposed = job.proposals.some((p) => p.talentId === user?.id);

  return (
    <article className="mx-auto max-w-4xl px-4 py-12">
      <Link href="/jobs" className="text-sm text-blue-600 hover:text-blue-700">
        ← All jobs
      </Link>
      <h1 className="mt-6 font-serif text-4xl text-slate-900">{job.title}</h1>
      {job.skills.length > 0 && (
        <div className="mt-4 flex flex-wrap gap-2">
          {job.skills.map((js) => (
            <span
              key={js.skillId}
              className="rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700"
            >
              {js.skill.name}
            </span>
          ))}
        </div>
      )}
      {isOwner && (
        <Link
          href={`/jobs/${slug}/edit`}
          className="mt-4 inline-block text-sm font-semibold text-blue-600"
        >
          Edit job
        </Link>
      )}
      <div className="mt-4 flex flex-wrap gap-3 text-sm text-slate-600">
        <span className="font-semibold text-slate-900">
          {formatMoney(Number(job.budgetMin))} – {formatMoney(Number(job.budgetMax))}
          {job.billingMode === "HOURLY" ? " / hr" : ""}
        </span>
        <span>·</span>
        <span className="capitalize">{job.environment.toLowerCase()}</span>
        <span>·</span>
        <span className="capitalize">{job.experienceLevel.toLowerCase()}</span>
      </div>
      <p className="mt-8 whitespace-pre-wrap text-slate-700">{job.description}</p>

      {canPropose && !alreadyProposed && (
        <div className="mt-10">
          <ProposalForm jobId={job.id} />
        </div>
      )}

      {user?.role === UserRole.TALENT && alreadyProposed && (
        <Link
          href={`/jobs/${slug}/chat/${user.id}`}
          className="mt-6 inline-block text-sm font-semibold text-blue-600"
        >
          Message client →
        </Link>
      )}

      {isOwner && (
        <section className="mt-12">
          <h2 className="text-xl font-semibold">Proposals ({job.proposals.length})</h2>
          <div className="mt-6">
            <ProposalInbox proposals={job.proposals} jobSlug={slug} />
          </div>
        </section>
      )}
    </article>
  );
}
