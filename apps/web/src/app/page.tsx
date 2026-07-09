import Link from "next/link";
import { ArrowRight, Lock, Scale, ShieldCheck } from "lucide-react";
import { VerificationTier } from "@fnm/database";
import { listTalents } from "@/actions/talents";
import { listProofClients, getFeaturedTestimonial } from "@/actions/proof";
import { PortraitCard, type PortraitTalent } from "@/components/home/portrait-card";
import { TimezoneBand } from "@/components/home/timezone-band";
import { CategoryGrid } from "@/components/category-grid";
import { isDatabaseConfigured } from "@/lib/env";
import { routes } from "@/lib/routes";

export const revalidate = 3600;

const FALLBACK_CLIENTS = [
  "Canva",
  "Atlassian",
  "Afterpay",
  "Culture Amp",
  "SafetyCulture",
  "Linktree",
];

const FALLBACK_TESTIMONIAL = {
  quote:
    "We replaced two agencies and an offshore squad with three verified freelancers from FNM. Six weeks to launch, fixed-price milestones, no surprise invoices. We interviewed all three on video before the first one started.",
  authorName: "Jess Suthar",
  authorTitle: "VP Product, fintech",
  authorInitials: "JS",
};

const FALLBACK_PORTRAITS: PortraitTalent[] = [
  { firstName: "Mei", lastName: "Tanaka", title: "Senior product designer", city: "New York", country: "NY", verificationTier: VerificationTier.VERIFIED, verified: true },
  { firstName: "Daniel", lastName: "Okafor", title: "Full-stack engineer", city: "Los Angeles", country: "CA", verificationTier: VerificationTier.TOP_RATED, verified: true },
  { firstName: "Priya", lastName: "Iyer", title: "Brand identity designer", city: "Chicago", country: "IL", verificationTier: VerificationTier.VERIFIED, verified: true },
  { firstName: "Tom", lastName: "Fitzgerald", title: "Growth marketer", city: "Austin", country: "TX", verificationTier: VerificationTier.VERIFIED, verified: true },
  { firstName: "Aoife", lastName: "Walker", title: "Technical writer", city: "Seattle", country: "WA", verificationTier: VerificationTier.VERIFIED, verified: true },
  { firstName: "Ruben", lastName: "Santos", title: "iOS engineer", city: "New York", country: "NY", verificationTier: VerificationTier.TOP_RATED, verified: true },
];

const FEATURE_PILLARS = [
  {
    icon: ShieldCheck,
    title: "Verified, not anonymous.",
    body: "Government-ID checked. Profile verified before hire. The person you interview is the person who delivers the work.",
  },
  {
    icon: Lock,
    title: "Escrow before scope creep.",
    body: "Funds sit in escrow until you accept the milestone. Pay only for work you approve.",
  },
  {
    icon: Scale,
    title: "Disputes resolved by humans.",
    body: "If a milestone goes sideways, a real mediator reads the thread. Resolutions feed back into Job Success Score.",
  },
];

const VERIFY_STEPS = [
  { step: "01", title: "Apply", body: "Anyone can apply. We accept a portfolio, not a résumé." },
  { step: "02", title: "ID check", body: "Email verification and Stripe payout setup before you can be hired." },
  { step: "03", title: "Deliver", body: "Complete contracts with strong reviews to earn a public success score." },
];

export default async function HomePage() {
  const dbReady = isDatabaseConfigured();
  const [talents, proofClients, testimonial] = await Promise.all([
    listTalents({}),
    listProofClients(),
    getFeaturedTestimonial(),
  ]);

  const clients =
    proofClients.length > 0 ? proofClients.map((c) => c.name) : FALLBACK_CLIENTS;
  const quote = testimonial ?? FALLBACK_TESTIMONIAL;

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

  const portraits = realPortraits.length >= 4 ? realPortraits : FALLBACK_PORTRAITS;

  return (
    <div>
      {!dbReady && (
        <div className="border-b border-ochre-500/30 bg-ochre-100 px-4 py-3 text-center text-sm text-ochre-700">
          Database is not connected. Set <code className="font-mono">DATABASE_URL</code> in your
          environment.
        </div>
      )}

      {/* Hero */}
      <section className="gradient-hero-mesh border-b border-bone-200 pt-28 pb-16 md:pt-36 md:pb-24">
        <div className="container-elite">
          <div className="grid items-end gap-10 lg:grid-cols-12">
            <div className="lg:col-span-7">
              <p className="eyebrow mb-5">Verified humans · Built for the US</p>
              <h1
                className="font-serif text-balance font-medium leading-[1.02] tracking-tight text-ink-900"
                style={{ fontSize: "clamp(40px, 6.4vw, 72px)" }}
              >
                Hire someone you can{" "}
                <span className="font-display-italic text-eucalyptus">actually meet.</span>
              </h1>
              <p className="mt-6 max-w-[560px] text-[17px] leading-relaxed text-ink-700 md:text-[18.5px]">
                The marketplace for clients who want to interview a real human, fund the work in
                escrow, and meet them in person if it matters. No bots, no anonymous résumés, no
                3 a.m. Slack replies.
              </p>
              <div className="mt-8 flex flex-wrap gap-3">
                <Link href={routes.talents} className="btn-elite">
                  Find verified talent
                  <ArrowRight className="ml-1.5 h-4 w-4" />
                </Link>
                <Link href="/trust" className="btn-secondary">
                  How we verify
                </Link>
              </div>
            </div>
            <div className="lg:col-span-5">
              <TimezoneBand />
            </div>
          </div>
        </div>
      </section>

      {/* Portrait wall */}
      <section className="surface-paper border-t border-bone-200 py-20 md:py-28">
        <div className="container-elite">
          <div className="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div className="max-w-2xl">
              <p className="eyebrow mb-3">The verified humans</p>
              <h2 className="font-serif text-balance text-[30px] leading-[1.1] font-medium text-ink-900 md:text-[40px]">
                Real names, US cities, real availability.
              </h2>
              <p className="mt-3 text-[15.5px] text-ink-700">
                Every card here is a freelancer who has been verified on the platform. The stamp in
                the corner is earned through completed work, not generated.
              </p>
            </div>
            <Link
              href={routes.talents}
              className="inline-flex items-center gap-1.5 text-[13.5px] font-semibold text-eucalyptus hover:text-eucalyptus-deep"
            >
              Browse the full directory
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

      {/* Proof clients */}
      <section className="surface-cream border-y border-bone-200 py-14">
        <div className="container-elite">
          <div className="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <p className="eyebrow text-ink-500">
              Trusted by product, growth, and design teams
            </p>
            <div className="flex flex-wrap items-center gap-x-8 gap-y-3">
              {clients.map((name) => (
                <span
                  key={name}
                  className="font-serif text-[18px] tracking-tight text-ink-500 md:text-[20px]"
                >
                  {name}
                </span>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Verification funnel */}
      <section className="surface-paper py-20 md:py-28">
        <div className="container-elite">
          <div className="grid items-start gap-12 lg:grid-cols-12">
            <div className="lg:col-span-4">
              <p className="eyebrow mb-3">The funnel</p>
              <h2 className="font-serif text-balance text-[30px] leading-[1.1] font-medium text-ink-900 md:text-[38px]">
                Why a &ldquo;verified human&rdquo; badge here means more than five stars anywhere
                else.
              </h2>
              <p className="mt-4 text-[15px] leading-relaxed text-ink-700">
                The badge is earned, not bought. We turn down work to keep this number honest.
              </p>
              <Link
                href="/trust"
                className="mt-6 inline-flex items-center gap-1.5 text-[13.5px] font-semibold text-eucalyptus hover:text-eucalyptus-deep"
              >
                Read the full Trust Centre
                <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
            <div className="grid gap-4 sm:grid-cols-3 lg:col-span-8">
              {VERIFY_STEPS.map((s) => (
                <div key={s.step} className="card-elite">
                  <p className="mb-3 font-serif text-[34px] leading-none text-ochre-700">
                    {s.step}
                  </p>
                  <p className="text-[16px] font-semibold text-ink-900">{s.title}</p>
                  <p className="mt-1.5 text-[13.5px] leading-relaxed text-ink-500">{s.body}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Trust pillars */}
      <section className="surface-cream border-t border-bone-200 py-20 md:py-24">
        <div className="container-elite">
          <div className="grid gap-5 md:grid-cols-3">
            {FEATURE_PILLARS.map((p) => (
              <article key={p.title} className="card-featured bg-white p-6">
                <div className="mb-5 flex h-11 w-11 items-center justify-center rounded-lg border border-ochre-500/30 bg-ochre-100 text-ochre-700">
                  <p.icon className="h-5 w-5" aria-hidden />
                </div>
                <h3 className="font-serif text-[22px] leading-tight font-medium text-ink-900">
                  {p.title}
                </h3>
                <p className="mt-3 text-[14.5px] leading-relaxed text-ink-700">{p.body}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      {/* Testimonial */}
      <section className="surface-eucalyptus py-20 md:py-28">
        <div className="container-narrow">
          <p className="eyebrow mb-5 text-bone/80">An outcome, not a vibe</p>
          <blockquote className="font-serif text-balance text-[26px] leading-[1.2] font-medium text-bone md:text-[34px]">
            &ldquo;{quote.quote}&rdquo;
          </blockquote>
          <div className="mt-8 flex items-center gap-3">
            <div className="grid h-11 w-11 place-items-center rounded-full bg-bone font-semibold text-eucalyptus-700">
              {quote.authorInitials ?? quote.authorName.slice(0, 2).toUpperCase()}
            </div>
            <div>
              <p className="text-[14.5px] font-semibold text-bone">{quote.authorName}</p>
              {quote.authorTitle ? (
                <p className="text-[13px] text-bone/70">{quote.authorTitle}</p>
              ) : null}
            </div>
          </div>
        </div>
      </section>

      {/* Dual CTA */}
      <section className="surface-paper border-t border-bone-200 py-20 md:py-28">
        <div className="container-elite">
          <div className="grid gap-5 md:grid-cols-2">
            <div className="card-featured p-8">
              <p className="eyebrow mb-3">For clients</p>
              <h3 className="font-serif text-[28px] leading-tight font-medium text-ink-900">
                Hire a verified human this week.
              </h3>
              <p className="mt-3 text-[14.5px] text-ink-700">
                Post a brief, review shortlisted proposals, and fund the first milestone in escrow.
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
                Get the badge that means something.
              </h3>
              <p className="mt-3 text-[14.5px] text-ink-700">
                Complete your profile, set up payouts, and build a track record clients can trust.
              </p>
              <div className="mt-6 flex flex-wrap gap-2">
                <Link href={routes.signUp("talent")} className="btn-elite">
                  Apply to verify
                </Link>
                <Link href={routes.jobs} className="btn-secondary">
                  Find work
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Categories */}
      <section className="container-elite section-padding">
        <CategoryGrid />
      </section>
    </div>
  );
}
