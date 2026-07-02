import Link from "next/link";
import { ShieldCheck, Lock, Star, ArrowRight } from "lucide-react";
import { listOpenJobs } from "@/actions/jobs";
import { listTalents } from "@/actions/talents";
import { listProofClients, getFeaturedTestimonial } from "@/actions/proof";
import { CategoryGrid } from "@/components/category-grid";
import { JobCard } from "@/components/job-card";
import { TalentCard } from "@/components/talent-card";
import { MarketingHero, MarketingClosingBand } from "@/components/layout/marketing-hero";
import { ButtonLink } from "@/components/ui/button";
import { isDatabaseConfigured } from "@/lib/env";
import { routes } from "@/lib/routes";

export const revalidate = 3600;

const FALLBACK_CLIENTS = ["Stripe", "Notion", "Linear", "Vercel"];

const FALLBACK_TESTIMONIAL = {
  quote:
    "We replaced two agencies with three freelancers from the platform. Six weeks to launch, fixed-price milestones, no surprise invoices.",
  authorName: "Jordan Lee",
  authorTitle: "VP Product",
  authorInitials: "JL",
};

const TRUST_PILLARS = [
  {
    icon: ShieldCheck,
    title: "Verified profiles",
    body: "Freelancers complete email verification and Stripe payout setup before they can be hired.",
  },
  {
    icon: Lock,
    title: "Escrow milestones",
    body: "Funds sit in escrow until you accept each milestone. Pay only for work you approve.",
  },
  {
    icon: Star,
    title: "Reviews & success score",
    body: "Job Success Score combines completion rate, on-time delivery, ratings, and repeat clients.",
  },
];

export default async function HomePage() {
  const dbReady = isDatabaseConfigured();
  const [jobs, talents, proofClients, testimonial] = await Promise.all([
    listOpenJobs(),
    listTalents({}),
    listProofClients(),
    getFeaturedTestimonial(),
  ]);

  const clients =
    proofClients.length > 0 ? proofClients.map((c) => c.name) : FALLBACK_CLIENTS;
  const quote = testimonial ?? FALLBACK_TESTIMONIAL;

  const featuredTalents = talents.slice(0, 3);

  return (
    <div>
      {!dbReady && (
        <div className="border-b border-ochre-500/30 bg-ochre-100 px-4 py-3 text-center text-sm text-ochre-700">
          Database is not connected. Set <code className="font-mono">DATABASE_URL</code> in your
          environment (see docs/ENVIRONMENT.md).
        </div>
      )}

      <MarketingHero
        eyebrow="Local & remote talent"
        title="Hire freelancers you can"
        italicTail="trust"
        lead="Post a job, review proposals, fund milestones in escrow, and manage contracts — one modern marketplace built for speed and accountability."
        primaryCta={{ label: "I want to hire", href: routes.signUp("client") }}
        secondaryCta={{ label: "I want to find work", href: routes.signUp("talent") }}
      />

      <section className="container-elite section-padding">
        <p className="eyebrow mb-8">Why Freelance Near Me</p>
        <div className="grid gap-8 md:grid-cols-3">
          {TRUST_PILLARS.map((pillar) => (
            <article key={pillar.title} className="rounded-xl border border-bone-200 bg-white p-6">
              <pillar.icon className="h-6 w-6 text-ochre-500" aria-hidden />
              <h3 className="mt-4 font-serif text-xl font-medium text-ink-900">{pillar.title}</h3>
              <p className="mt-2 text-sm leading-relaxed text-ink-700">{pillar.body}</p>
            </article>
          ))}
        </div>
      </section>

      <section className="surface-bone-alt border-y border-bone-200">
        <div className="container-elite section-padding">
          <p className="eyebrow mb-6">Trusted by teams at</p>
          <div className="flex flex-wrap items-center gap-x-10 gap-y-4">
            {clients.map((name) => (
              <span
                key={name}
                className="font-serif text-lg font-medium text-ink-500 md:text-xl"
              >
                {name}
              </span>
            ))}
          </div>
          <blockquote className="mt-12 max-w-3xl border-l-2 border-ochre-500 pl-6">
            <p className="font-serif text-xl leading-relaxed text-ink-900 md:text-2xl">
              &ldquo;{quote.quote}&rdquo;
            </p>
            <footer className="mt-4 text-sm text-ink-500">
              <span className="font-semibold text-ink-700">{quote.authorName}</span>
              {"authorTitle" in quote && quote.authorTitle ? ` · ${quote.authorTitle}` : null}
            </footer>
          </blockquote>
        </div>
      </section>

      <section className="container-elite section-padding">
        <div className="flex items-end justify-between">
          <div>
            <p className="eyebrow mb-2">Open projects</p>
            <h2 className="font-serif text-3xl text-ink-900">Latest jobs</h2>
          </div>
          <Link
            href={routes.jobs}
            className="inline-flex items-center gap-1 text-sm font-semibold text-ochre-700 hover:text-ochre-500"
          >
            View all <ArrowRight className="h-4 w-4" />
          </Link>
        </div>
        <div className="mt-8 grid gap-6 md:grid-cols-2">
          {jobs.slice(0, 4).map((job) => (
            <JobCard
              key={job.id}
              slug={job.slug}
              title={job.title}
              description={job.description}
              budgetMin={job.budgetMin}
              budgetMax={job.budgetMax}
              billingMode={job.billingMode}
              environment={job.environment}
              featured={job.featured}
              urgent={job.urgent}
              category={job.category}
              poster={job.poster}
              proposalCount={job._count.proposals}
            />
          ))}
        </div>
        {jobs.length === 0 && (
          <p className="mt-6 text-ink-600">
            No jobs yet. Run <code className="rounded bg-bone-200 px-1">npm run db:seed</code> or{" "}
            <ButtonLink href={routes.postJob} variant="quiet" className="ml-1 inline-flex">
              post the first job
            </ButtonLink>
          </p>
        )}
      </section>

      {featuredTalents.length > 0 && (
        <section className="surface-bone-alt border-y border-bone-200">
          <div className="container-elite section-padding">
            <div className="flex items-end justify-between">
              <div>
                <p className="eyebrow mb-2">Featured talent</p>
                <h2 className="font-serif text-3xl text-ink-900">Verified freelancers</h2>
              </div>
              <Link
                href={routes.talents}
                className="inline-flex items-center gap-1 text-sm font-semibold text-ochre-700 hover:text-ochre-500"
              >
                View all <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
            <div className="mt-8 grid gap-6 md:grid-cols-3">
              {featuredTalents.map((t) => {
                const reviewCount = t.reviewsReceived.length;
                const averageRating =
                  reviewCount > 0
                    ? t.reviewsReceived.reduce((sum, r) => sum + r.rating, 0) / reviewCount
                    : 0;
                return (
                  <TalentCard
                    key={t.id}
                    username={t.username}
                    firstName={t.firstName}
                    lastName={t.lastName}
                    headline={t.talentProfile?.headline}
                    hourlyRate={t.talentProfile?.hourlyRate}
                    availability={t.talentProfile?.availability}
                    verified={t.talentProfile?.verified}
                    verificationTier={t.talentProfile?.verificationTier}
                    jobSuccessScore={t.talentProfile?.jobSuccessScore}
                    skills={t.talentProfile?.skills}
                    averageRating={averageRating}
                    reviewCount={reviewCount}
                    city={t.city}
                    postcode={t.postcode}
                  />
                );
              })}
            </div>
          </div>
        </section>
      )}

      <section className="container-elite section-padding">
        <p className="eyebrow mb-6">Browse by category</p>
        <CategoryGrid />
      </section>

      <MarketingClosingBand
        eyebrow="Get started"
        title="Ready to hire or find your next project?"
        lead="Create a free account and join the marketplace in minutes."
        primaryCta={{ label: "Create account", href: routes.signUp("client") }}
        secondaryCta={{ label: "Browse jobs", href: routes.jobs }}
      />
    </div>
  );
}
