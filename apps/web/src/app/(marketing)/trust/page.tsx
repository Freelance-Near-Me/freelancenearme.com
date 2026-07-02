import { MarketingHero } from "@/components/layout/marketing-hero";
import { ButtonLink } from "@/components/ui/button";
import { routes } from "@/lib/routes";

const TRUST_ITEMS = [
  {
    title: "Verification tiers",
    body: "Freelancers progress from email verified to fully verified (payout setup complete) to top rated (Job Success Score 90+ with 3+ completed contracts).",
  },
  {
    title: "Escrow milestones",
    body: "Clients fund milestones via Stripe Checkout. Funds are released only after the client approves submitted work.",
  },
  {
    title: "Job Success Score",
    body: "A weighted score (0–100) based on completion rate, on-time delivery, ratings, dispute-free rate, and repeat clients. Published only after three completed contracts.",
  },
  {
    title: "Reviews",
    body: "Clients leave reviews after contracts complete. Reviews feed into the success score and appear on public profiles.",
  },
];

export default function TrustPage() {
  return (
    <>
      <MarketingHero
        eyebrow="Trust"
        title="Verification and"
        italicTail="escrow"
        lead="We combine profile verification, milestone escrow, and performance scoring so you can hire with confidence."
        primaryCta={{ label: "Browse talent", href: routes.talents }}
        secondaryCta={{ label: "How it works", href: "/how-it-works" }}
      />
      <div className="container-elite section-padding">
        <div className="grid gap-8 md:grid-cols-2">
          {TRUST_ITEMS.map((item) => (
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
