import Link from "next/link";
import { UserRole } from "@fnm/database";
import {
  getTalentStripeStatus,
  refreshStripeConnectStatus,
  startStripeConnectOnboarding,
} from "@/actions/stripe-connect";
import { requireRole } from "@/lib/auth";
import { Button } from "@/components/ui/button";

export default async function PayoutsSettingsPage({
  searchParams,
}: {
  searchParams: Promise<{ connected?: string; refresh?: string }>;
}) {
  await requireRole(UserRole.TALENT);
  const params = await searchParams;

  if (params.connected || params.refresh) {
    await refreshStripeConnectStatus();
  }

  const status = await getTalentStripeStatus();

  return (
    <div className="mx-auto max-w-lg px-4 py-12">
      <Link href="/dashboard" className="text-sm text-blue-600">
        ← Dashboard
      </Link>
      <h1 className="mt-6 font-serif text-3xl text-slate-900">Payout settings</h1>
      <p className="mt-2 text-slate-600">
        Connect Stripe to receive milestone payments when clients approve your work.
      </p>

      {!status.configured && (
        <p className="mt-6 rounded-xl bg-amber-50 p-4 text-sm text-amber-900">
          Stripe is not configured on this environment. Add <code>STRIPE_SECRET_KEY</code> to
          enable payouts.
        </p>
      )}

      {status.configured && (
        <div className="mt-8 space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
          <dl className="space-y-2 text-sm">
            <div className="flex justify-between">
              <dt className="text-slate-500">Account</dt>
              <dd className="font-mono text-xs">{status.accountId ?? "Not connected"}</dd>
            </div>
            <div className="flex justify-between">
              <dt className="text-slate-500">Charges enabled</dt>
              <dd>{status.chargesEnabled ? "Yes" : "No"}</dd>
            </div>
            <div className="flex justify-between">
              <dt className="text-slate-500">Payouts enabled</dt>
              <dd>{status.payoutsEnabled ? "Yes" : "No"}</dd>
            </div>
          </dl>

          {status.ready ? (
            <p className="text-sm font-medium text-green-700">
              You&apos;re ready to receive payments.
            </p>
          ) : (
            <form action={startStripeConnectOnboarding}>
              <Button type="submit" className="w-full">
                {status.accountId ? "Complete Stripe setup" : "Connect with Stripe"}
              </Button>
            </form>
          )}

          {status.accountId && (
            <form action={refreshStripeConnectStatus}>
              <Button type="submit" variant="secondary" className="w-full">
                Refresh status
              </Button>
            </form>
          )}
        </div>
      )}
    </div>
  );
}
