import { MarketingHero } from "@/components/layout/marketing-hero";
import { ButtonLink } from "@/components/ui/button";
import { routes } from "@/lib/routes";

export default function HowItWorksPage() {
  const steps = [
    {
      title: "Post or browse",
      body: "Clients post jobs with budget and scope. Talent browses open projects.",
    },
    {
      title: "Propose",
      body: "Freelancers submit proposals with bid, timeline, and cover letter.",
    },
    {
      title: "Hire",
      body: "Clients shortlist, send an offer, and open a contract.",
    },
    {
      title: "Deliver & pay",
      body: "Work in the contract workspace: upload deliverables, fund milestones with Stripe escrow, and release payout on approval.",
    },
  ];

  return (
    <>
      <MarketingHero
        eyebrow="How it works"
        title="From job post to"
        italicTail="payout"
        lead="Four steps to hire freelancers with escrow protection and clear milestones."
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
