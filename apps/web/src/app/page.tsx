import type { Metadata } from "next";
import Link from "next/link";
import { ArrowRight, Lock, Scale, ShieldCheck } from "lucide-react";
import { listTalents } from "@/actions/talents";
import { listProofClients, getFeaturedTestimonial } from "@/actions/proof";
import { PortraitCard, type PortraitTalent } from "@/components/home/portrait-card";
import { TimezoneBand } from "@/components/home/timezone-band";
import { CategoryGrid } from "@/components/category-grid";
import { isDatabaseConfigured } from "@/lib/env";
import { platformFeePercent } from "@/lib/fees";
import { routes } from "@/lib/routes";

export const revalidate = 3600;

export const metadata: Metadata = {
  title: {
    absolute: "Freelance Near Me · Hire freelancers by city or ZIP code",
  },
  description:
    "Search US freelancers by city or ZIP code. Email and payout checks before hire. Milestone payments stay held until you approve the work.",
};

const EXAMPLE_PORTRAITS: PortraitTalent[] = [
  { firstName: "Mei", lastName: "Tanaka", title: "Senior product designer", city: "New York", country: "NY", example: true },
  { firstName: "Daniel", lastName: "Okafor", title: "Full-stack engineer", city: "Los Angeles", country: "CA", example: true },
  { firstName: "Priya", lastName: "Iyer", title: "Brand identity designer", city: "Chicago", country: "IL", example: true },
  { firstName: "Tom", lastName: "Fitzgerald", title: "Growth marketer", city: "Austin", country: "TX", example: true },
  { firstName: "Aoife", lastName: "Walker", title: "Technical writer", city: "Seattle", country: "WA", example: true },
  { firstName: "Ruben", lastName: "Santos", title: "iOS engineer", city: "New York", country: "NY", example: true },
];

const FEATURE_PILLARS = [
  {
    icon: ShieldCheck,
    title: "Checked, not anonymous.",
    body: "A freelancer confirms their email and finishes Stripe payout setup before a client can hire them. We do not run a government ID check.",
  },
  {
    icon: Lock,
    title: "Pay only for work you approve.",
    body: "You fund a milestone through Stripe. The money stays held until you approve the delivery. Then we release it, minus the platform fee.",
  },
  {
    icon: Scale,
    title: "Leave it unapproved if you disagree.",
    body: "If a delivery is wrong, do not approve the milestone. Email support and the funds stay held while you sort it out.",
  },
];

const VERIFY_STEPS = [
  { step: "01", title: "Apply", body: "Anyone can apply. We ask for a portfolio, not a résumé." },
  { step: "02", title: "Checks", body: "Email confirmation and Stripe payout setup. This is not a government ID check." },
  { step: "03", title: "Deliver", body: "Completed contracts and reviews build a public success score." },
];

export default async function HomePage() {
  const dbReady = isDatabaseConfigured();
  const [talents, proofClients, testimonial] = await Promise.all([
    listTalents({}),
    listProofClients(),
    getFeaturedTestimonial(),
  ]);

  const realPortraits: PortraitTalent[] = talents.slice(0, 6).map((t) => ({
    username: t.username,
    firstName: t.firstName,
    lastName: t.lastName,
    title: t.talentProfile?.headline,
    city: t.city,
    country: t.country,
    avatarUrl: t.avatarUrl,
    verificationTier: t.talentProfile?.verificationTier,
    verified: t.talentProfile?.verified,
  }));

  const showingExamples = realPortraits.length === 0;
  const portraits = showingExamples ? EXAMPLE_PORTRAITS : realPortraits;
  const feePercent = platformFeePercent();

  return (
    <div>
      {!dbReady && (
        <div className="border-b border-ochre-500/30 bg-ochre-100 px-4 py-3 text-center text-sm text-ochre-700">
          Database is not connected. Set <code className="font-mono">DATABASE_URL</code> in your
          environment.
        </div>
      )}

      <section className="gradient-hero-mesh border-b border-bone-200 pt-12 pb-12 md:pt-16 md:pb-16">
        <div className="container-elite">
          <div className="grid items-end gap-10 lg:grid-cols-12">
            <div className="lg:col-span-7">
              <p className="eyebrow mb-5">Built for the US</p>
              <h1
                className="font-serif text-balance font-medium leading-[1.02] tracking-tight text-ink-900"
                style={{ fontSize: "clamp(40px, 6.4vw, 72px)" }}
              >
                Hire a freelancer{" "}
                <span className="font-display-italic text-eucalyptus">near you.</span>
              </h1>
              <p className="mt-6 max-w-[560px] text-[17px] leading-relaxed text-ink-700 md:text-[18.5px]">
                Search by ZIP code or city, interview the person, and keep the payment held until
                you approve the work. Remote projects are welcome too.
              </p>
              <form action={routes.talents} method="get" className="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                <label className="sr-only" htmlFor="near-search">
                  ZIP code or city
                </label>
                <input
                  id="near-search"
                  name="nearPostcode"
                  placeholder="ZIP code or city, e.g. 10001 or Austin"
                  className="w-full rounded-lg border border-bone-200 bg-white px-4 py-3 text-sm text-ink-900 sm:max-w-sm"
                />
                <input type="hidden" name="radiusMiles" value="50" />
                <button type="submit" className="btn-elite">
                  Search near you
                  <ArrowRight className="ml-1.5 h-4 w-4" />
                </button>
              </form>
              <div className="mt-4 flex flex-wrap gap-4 text-sm">
                <Link href={routes.talents} className="font-semibold text-eucalyptus hover:text-eucalyptus-deep">
                  Browse all talent
                </Link>
                <Link href="/trust" className="font-semibold text-ink-700 hover:text-ink-900">
                  How we check freelancers
                </Link>
              </div>
            </div>
            <div className="lg:col-span-5">
              <TimezoneBand />
            </div>
          </div>
        </div>
      </section>

      <section className="surface-paper border-t border-bone-200 py-14 md:py-16">
        <div className="container-elite">
          <div className="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div className="max-w-2xl">
              <p className="eyebrow mb-3">{showingExamples ? "Examples, not listings" : "On the platform"}</p>
              <h2 className="font-serif text-balance text-[30px] leading-[1.1] font-medium text-ink-900 md:text-[40px]">
                {showingExamples ? "What a profile looks like." : "Freelancers you can hire."}
              </h2>
              <p className="mt-3 text-[15.5px] text-ink-700">
                {showingExamples
                  ? "These cards are examples. They are not people on Freelance Near Me, and they are not verified. Real profiles appear here after a freelancer confirms their email and finishes payout setup."
                  : "Each card is a freelancer who has confirmed their email and finished payout setup."}
              </p>
            </div>
            <Link
              href={routes.talents}
              className="inline-flex items-center gap-1.5 text-[13.5px] font-semibold text-eucalyptus hover:text-eucalyptus-deep"
            >
              Browse the directory
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
          <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {portraits.map((talent, i) => (
              <PortraitCard key={`${talent.firstName}-${talent.lastName}-${i}`} talent={talent} />
            ))}
          </div>
        </div>
      </section>

      {proofClients.length > 0 && (
        <section className="surface-cream border-y border-bone-200 py-10">
          <div className="container-elite">
            <div className="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
              <p className="eyebrow text-ink-500">Teams that have hired here</p>
              <div className="flex flex-wrap items-center gap-x-8 gap-y-3">
                {proofClients.map((client) => (
                  <span
                    key={client.id}
                    className="font-serif text-[18px] tracking-tight text-ink-500 md:text-[20px]"
                  >
                    {client.name}
                  </span>
                ))}
              </div>
            </div>
          </div>
        </section>
      )}

      <section className="surface-paper py-14 md:py-16">
        <div className="container-elite">
          <div className="grid items-start gap-8 lg:grid-cols-12">
            <div className="lg:col-span-4">
              <p className="eyebrow mb-3">Before you hire</p>
              <h2 className="font-serif text-balance text-[30px] leading-[1.1] font-medium text-ink-900 md:text-[38px]">
                What “checked” means on this site.
              </h2>
              <p className="mt-4 text-[15px] leading-relaxed text-ink-700">
                Email confirmation and payout setup. Not a government ID check, and not a badge you can buy.
              </p>
              <Link
                href="/trust"
                className="mt-6 inline-flex items-center gap-1.5 text-[13.5px] font-semibold text-eucalyptus hover:text-eucalyptus-deep"
              >
                Read the Trust page
                <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
            <div className="grid gap-4 sm:grid-cols-3 lg:col-span-8">
              {VERIFY_STEPS.map((s) => (
                <div key={s.step} className="card-elite">
                  <p className="mb-3 font-serif text-[34px] leading-none text-ochre-700">{s.step}</p>
                  <p className="text-[16px] font-semibold text-ink-900">{s.title}</p>
                  <p className="mt-1.5 text-[13.5px] leading-relaxed text-ink-500">{s.body}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      <section className="surface-cream border-t border-bone-200 py-14 md:py-16">
        <div className="container-elite">
          <div className="grid gap-5 md:grid-cols-3">
            {FEATURE_PILLARS.map((p) => (
              <article key={p.title} className="card-featured bg-white p-6">
                <div className="mb-5 flex h-11 w-11 items-center justify-center rounded-lg border border-ochre-500/30 bg-ochre-100 text-ochre-700">
                  <p.icon className="h-5 w-5" aria-hidden />
                </div>
                <h3 className="font-serif text-[22px] leading-tight font-medium text-ink-900">{p.title}</h3>
                <p className="mt-3 text-[14.5px] leading-relaxed text-ink-700">{p.body}</p>
              </article>
            ))}
          </div>
          <p className="mt-6 text-sm text-ink-500">Platform fee: {feePercent}% of each milestone, taken when you release payment.</p>
        </div>
      </section>

      {testimonial && (
        <section className="surface-eucalyptus py-14 md:py-16">
          <div className="container-narrow">
            <p className="eyebrow mb-5 text-bone/80">From a client</p>
            <blockquote className="font-serif text-balance text-[26px] leading-[1.2] font-medium text-bone md:text-[34px]">
              &ldquo;{testimonial.quote}&rdquo;
            </blockquote>
            <div className="mt-8 flex items-center gap-3">
              <div className="grid h-11 w-11 place-items-center rounded-full bg-bone font-semibold text-eucalyptus-700">
                {testimonial.authorInitials ?? testimonial.authorName.slice(0, 2).toUpperCase()}
              </div>
              <div>
                <p className="text-[14.5px] font-semibold text-bone">{testimonial.authorName}</p>
                {testimonial.authorTitle ? (
                  <p className="text-[13px] text-bone/70">{testimonial.authorTitle}</p>
                ) : null}
              </div>
            </div>
          </div>
        </section>
      )}

      <section className="surface-paper border-t border-bone-200 py-14 md:py-16">
        <div className="container-elite">
          <div className="grid gap-5 md:grid-cols-2">
            <div className="card-featured p-8">
              <p className="eyebrow mb-3">For clients</p>
              <h3 className="font-serif text-[28px] leading-tight font-medium text-ink-900">
                Post a project and fund the first milestone.
              </h3>
              <p className="mt-3 text-[14.5px] text-ink-700">
                Review proposals, hire, and release payment only when you approve the work. The platform fee is {feePercent}%.
              </p>
              <div className="mt-6 flex flex-wrap gap-2">
                <Link href={routes.postJob} className="btn-elite">
                  Post a project
                </Link>
                <Link href={routes.talents} className="btn-secondary">
                  Browse talent
                </Link>
              </div>
            </div>
            <div className="card-featured p-8">
              <p className="eyebrow mb-3">For freelancers</p>
              <h3 className="font-serif text-[28px] leading-tight font-medium text-ink-900">
                Confirm your email and set up payouts.
              </h3>
              <p className="mt-3 text-[14.5px] text-ink-700">
                That is the check clients see. Completed work and reviews build your public score after that.
              </p>
              <div className="mt-6 flex flex-wrap gap-2">
                <Link href={routes.signUp("talent")} className="btn-elite">
                  Create a freelancer account
                </Link>
                <Link href={routes.jobs} className="btn-secondary">
                  Find work
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="container-elite py-14 md:py-16">
        <CategoryGrid />
      </section>
    </div>
  );
}
