import type { Metadata } from "next";
import { MarketingHero } from "@/components/layout/marketing-hero";
import { ButtonLink } from "@/components/ui/button";
import { platformFeeSummary } from "@/lib/fees";
import { routes } from "@/lib/routes";

export const metadata: Metadata = {
  title: "Trust",
  description:
    "How Freelance Near Me checks freelancers, holds milestone payments until you approve them, and scores completed work.",
};

export default function TrustPage() {
  const items = [
    {
      title: "What we actually check",
      body: "Freelancers start with a confirmed email. They become verified when Stripe payout setup is complete. Top rated is a job success score of 90 or higher after at least three completed contracts. We do not run a government ID check.",
    },
    {
      title: "Payments held until you approve",
      body: "Clients fund milestones through Stripe Checkout. The money stays held until the client approves the submitted work. Approving releases the payment to the freelancer. This is Stripe holding the charge, not a legal escrow account.",
    },
    {
      title: "Platform fee",
      body: platformFeeSummary(),
    },
    {
      title: "Job Success Score",
      body: "A score from 0 to 100 based on completion, on-time delivery, ratings, contracts that were not disputed, and repeat clients. It is published only after three completed contracts.",
    },
    {
      title: "If you disagree",
      body: "Do not approve a milestone you are unhappy with. Funds stay held. Email support@freelancenearme.com and include the contract. We read the thread with you. There is no separate mediation service, and released payments are not refunded automatically.",
    },
    {
      title: "Reviews",
      body: "Clients leave reviews after a contract is complete. Reviews feed the success score and appear on the public profile.",
    },
  ];

  return (
    <>
      <MarketingHero
        eyebrow="Trust"
        title="Checks, payment holds,"
        italicTail="and scores"
        lead="Email confirmation, Stripe payout setup, and milestone payments that stay held until you approve the work."
        primaryCta={{ label: "Browse talent", href: routes.talents }}
        secondaryCta={{ label: "How it works", href: "/how-it-works" }}
      />
      <div className="container-elite section-padding">
        <div className="grid gap-8 md:grid-cols-2">
          {items.map((item) => (
            <article key={item.title} className="rounded-xl border border-bone-200 bg-white p-6">
              <h2 className="font-serif text-xl font-medium text-ink-900">{item.title}</h2>
              <p className="mt-3 text-sm leading-relaxed text-ink-700">{item.body}</p>
            </article>
          ))}
        </div>
        <div className="mt-12 text-center">
          <ButtonLink href={routes.signUp("client")} variant="ink">
            Start hiring
          </ButtonLink>
        </div>
      </div>
    </>
  );
}
