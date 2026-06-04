import { MilestoneStatus } from "@fnm/database";
import { createMilestone, updateMilestoneStatus } from "@/actions/milestones";
import { createMilestoneCheckout } from "@/actions/payments";
import { isStripeConfigured } from "@/lib/stripe";
import { formatMoney } from "@/lib/utils";
import { Button } from "@/components/ui/button";

type Milestone = {
  id: string;
  title: string;
  description: string | null;
  amount: { toString(): string };
  status: MilestoneStatus;
  dueDate: Date | null;
};

const statusLabel: Record<MilestoneStatus, string> = {
  PENDING: "Awaiting payment",
  FUNDED: "Funded — in escrow",
  SUBMITTED: "Work submitted",
  APPROVED: "Approved",
  PAID: "Paid out",
  CANCELLED: "Cancelled",
};

export function MilestonePanel({
  contractId,
  milestones,
  isClient,
  isTalent,
  contractActive,
  talentPayoutsReady,
}: {
  contractId: string;
  milestones: Milestone[];
  isClient: boolean;
  isTalent: boolean;
  contractActive: boolean;
  talentPayoutsReady: boolean;
}) {
  const stripeOn = isStripeConfigured();

  return (
    <section className="mt-10">
      <h2 className="text-xl font-semibold text-slate-900">Milestones</h2>
      <p className="mt-1 text-sm text-slate-600">
        {stripeOn
          ? `Client funds milestones via Stripe Checkout. Platform fee: ${process.env.NEXT_PUBLIC_PLATFORM_FEE_PERCENT ?? "10"}%. Payout releases on approval.`
          : "Add STRIPE_SECRET_KEY to enable payments. Status updates work without Stripe in dev."}
      </p>

      {!talentPayoutsReady && contractActive && (
        <p className="mt-4 rounded-xl bg-amber-50 p-3 text-sm text-amber-900">
          Talent must{" "}
          <a href="/settings/payouts" className="font-semibold underline">
            connect Stripe payouts
          </a>{" "}
          before milestones can be funded.
        </p>
      )}

      <ul className="mt-6 space-y-3">
        {milestones.map((m) => (
          <li key={m.id} className="rounded-xl border border-slate-200 bg-white p-4">
            <div className="flex flex-wrap items-start justify-between gap-2">
              <div>
                <p className="font-medium text-slate-900">{m.title}</p>
                {m.description && <p className="mt-1 text-sm text-slate-600">{m.description}</p>}
              </div>
              <div className="text-right text-sm">
                <p className="font-semibold">{formatMoney(Number(m.amount))}</p>
                <p className="text-slate-500">{statusLabel[m.status]}</p>
              </div>
            </div>
            <div className="mt-3 flex flex-wrap gap-2">
              {isClient && m.status === MilestoneStatus.PENDING && contractActive && (
                <form action={createMilestoneCheckout.bind(null, m.id)}>
                  <Button type="submit" disabled={!talentPayoutsReady || !stripeOn}>
                    Fund milestone
                  </Button>
                </form>
              )}
              {isTalent && m.status === MilestoneStatus.FUNDED && contractActive && (
                <form action={updateMilestoneStatus.bind(null, m.id, MilestoneStatus.SUBMITTED)}>
                  <Button type="submit" variant="secondary">
                    Mark submitted
                  </Button>
                </form>
              )}
              {isClient && m.status === MilestoneStatus.SUBMITTED && (
                <form action={updateMilestoneStatus.bind(null, m.id, MilestoneStatus.APPROVED)}>
                  <Button type="submit">Approve & release payout</Button>
                </form>
              )}
            </div>
          </li>
        ))}
        {milestones.length === 0 && (
          <p className="text-sm text-slate-500">No milestones yet.</p>
        )}
      </ul>

      {isClient && contractActive && (
        <form action={createMilestone} className="mt-8 space-y-4 rounded-2xl border border-dashed border-slate-300 p-6">
          <input type="hidden" name="contractId" value={contractId} />
          <h3 className="font-medium">Add milestone</h3>
          <label className="block text-sm">
            <span className="font-medium">Title</span>
            <input name="title" required className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2" />
          </label>
          <label className="block text-sm">
            <span className="font-medium">Amount ($)</span>
            <input name="amount" type="number" min={1} required className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2" />
          </label>
          <label className="block text-sm">
            <span className="font-medium">Description</span>
            <textarea name="description" rows={2} className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2" />
          </label>
          <Button type="submit">Add milestone</Button>
        </form>
      )}
    </section>
  );
}
