import type { Metadata } from "next";
import { MarketingHero } from "@/components/layout/marketing-hero";
import { ButtonLink } from "@/components/ui/button";
import { platformFeePercent, platformFeeSummary } from "@/lib/fees";
import { SUPPORT_EMAIL } from "@/lib/site";
import { routes } from "@/lib/routes";

export const metadata: Metadata = {
  title: "How it works",
  description:
    "Post a job, check that a freelancer has confirmed their email and payouts, fund a milestone, and release payment when you approve the work.",
};

export default function HowItWorksPage() {
  const fee = platformFeePercent();
  const steps = [
    {
      title: "Search or post",
      body: "Clients can search freelancers by ZIP code or city, or post a job with the budget, location, and whether the work is local, remote, or hybrid.",
    },
    {
      title: "Checks before hire",
      body: "A freelancer confirms their email and finishes Stripe payout setup before a client can hire them. We do not run a government ID check. A success score is published only after three completed contracts.",
    },
    {
      title: "Propose and hire",
      body: "Freelancers send a proposal with a price, a timeline, and a note. The client shortlists, sends an offer, and opens a contract.",
    },
    {
      title: "Fund, deliver, approve",
      body: `Work happens in the contract. The client funds a milestone through Stripe and the money stays held until they approve the delivery. ${platformFeeSummary()}`,
    },
    {
      title: "Disagreements and refunds",
      body: `If the work is not right, leave the milestone unapproved and email ${SUPPORT_EMAIL} with the contract. Funds stay held while you sort it out. We do not run a separate mediation service. Once you approve and the payment is released, it is not refunded automatically. The platform fee is ${fee}% and is taken from the milestone at release, not added on top.`,
    },
  ];

  return (
    <>
      <MarketingHero
        eyebrow="How it works"
        title="From search to"
        italicTail="approved work"
        lead="Find someone by ZIP code or city, hire after the basic checks, and release payment only when you approve the milestone."
      />
      <div className="container-elite py-16">
        <ol className="mx-auto max-w-3xl space-y-8">
          {steps.map((s, i) => (
            <li key={s.title} className="flex gap-4">
              <span className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-ochre-100 font-semibold text-ochre-700">
                {i + 1}
              </span>
              <div>
                <h2 className="text-lg font-semibold text-ink-900">{s.title}</h2>
                <p className="mt-1 text-ink-600">{s.body}</p>
              </div>
            </li>
          ))}
        </ol>
        <div className="mt-12 text-center">
          <ButtonLink href={routes.signUp("client")} variant="ink">
            Get started
          </ButtonLink>
        </div>
      </div>
    </>
  );
}
