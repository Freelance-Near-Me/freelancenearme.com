import Link from "next/link";
import { notFound } from "next/navigation";
import { ContractStatus } from "@fnm/database";
import { listContractActivity } from "@/actions/activity";
import { acceptContract, getContract } from "@/actions/contracts";
import { listDeliverablesForContract } from "@/actions/deliverables";
import { listMilestones } from "@/actions/milestones";
import { ContractActivityTimeline } from "@/components/contract-activity-timeline";
import { DeliverablesPanel } from "@/components/deliverables-panel";
import { getCurrentUser } from "@/lib/auth";
import { formatMoney } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { MilestonePanel } from "@/components/milestone-panel";

export default async function ContractPage({
  params,
  searchParams,
}: {
  params: Promise<{ id: string }>;
  searchParams: Promise<{ funded?: string }>;
}) {
  const { id } = await params;
  const { funded } = await searchParams;
  const user = await getCurrentUser();
  if (!user) notFound();

  const contract = await getContract(id);
  if (!contract) notFound();

  const isTalent = user.id === contract.talentId;
  const isClient = user.id === contract.clientId;
  const canAccept =
    isTalent && contract.status === ContractStatus.PENDING_ACCEPTANCE;
  const milestones = await listMilestones(id);
  const deliverables = await listDeliverablesForContract(id);
  const activities = await listContractActivity(id);
  const contractActive = contract.status === ContractStatus.ACTIVE;
  const talentPayoutsReady = Boolean(
    contract.talent.talentProfile?.stripeChargesEnabled &&
      contract.talent.talentProfile?.stripePayoutsEnabled
  );

  return (
    <div className="mx-auto max-w-6xl px-4 py-12">
      <Link href="/dashboard" className="text-sm text-blue-600">
        ← Dashboard
      </Link>
      <h1 className="mt-6 font-serif text-3xl text-slate-900">{contract.title}</h1>
      <p className="mt-2 capitalize text-slate-600">
        {contract.status.toLowerCase().replace(/_/g, " ")} · {formatMoney(Number(contract.amount))}
      </p>

      {funded === "1" && (
        <p className="mt-4 rounded-xl bg-green-50 p-3 text-sm text-green-800">
          Payment received — milestone is now funded and held in escrow.
        </p>
      )}

      <div className="mt-8 rounded-2xl border border-slate-200 bg-white p-6">
        <dl className="grid gap-4 text-sm sm:grid-cols-2">
          <div>
            <dt className="text-slate-500">Client</dt>
            <dd className="font-medium">
              {contract.client.firstName} {contract.client.lastName}
            </dd>
          </div>
          <div>
            <dt className="text-slate-500">Talent</dt>
            <dd className="font-medium">
              {contract.talent.firstName} {contract.talent.lastName}
            </dd>
          </div>
          <div>
            <dt className="text-slate-500">Job</dt>
            <dd>
              <Link href={`/jobs/${contract.job.slug}`} className="text-blue-600">
                View job
              </Link>
            </dd>
          </div>
        </dl>
      </div>

      {canAccept && (
        <form action={acceptContract.bind(null, id)} className="mt-8">
          <Button type="submit">Accept contract</Button>
        </form>
      )}

      {isTalent && contractActive && !talentPayoutsReady && (
        <p className="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
          Connect Stripe to receive payments when milestones are approved.{" "}
          <a href="/settings/payouts" className="font-semibold text-amber-950 underline">
            Set up payouts
          </a>
        </p>
      )}

      <div className="mt-10 grid gap-8 lg:grid-cols-3">
        <div className="lg:col-span-2">
          <MilestonePanel
            contractId={id}
            milestones={milestones}
            isClient={isClient}
            isTalent={isTalent}
            contractActive={contractActive}
            talentPayoutsReady={talentPayoutsReady}
          />
          <DeliverablesPanel
            contractId={id}
            milestones={milestones}
            deliverables={deliverables}
            isTalent={isTalent}
            contractActive={contractActive}
          />
        </div>
        <div className="lg:col-span-1">
          <ContractActivityTimeline activities={activities} />
        </div>
      </div>
    </div>
  );
}
