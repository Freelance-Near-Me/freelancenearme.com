import Link from "next/link";
import type { ReactNode } from "react";

interface CtaSpec {
  label: string;
  href: string;
  external?: boolean;
}

interface MarketingHeroProps {
  eyebrow: string;
  title: ReactNode;
  italicTail?: string;
  lead?: ReactNode;
  primaryCta?: CtaSpec;
  secondaryCta?: CtaSpec;
  accent?: ReactNode;
  testId?: string;
}

function CtaLink({ cta, variant }: { cta: CtaSpec; variant: "ink" | "quiet" | "ochre" }) {
  const cls =
    variant === "ink" ? "btn-ink" : variant === "ochre" ? "btn-ochre" : "btn-quiet";
  if (cta.external) {
    return (
      <a href={cta.href} className={cls} data-testid={`cta-${variant}`}>
        {cta.label}
      </a>
    );
  }
  return (
    <Link href={cta.href} className={cls} data-testid={`cta-${variant}`}>
      {cta.label}
    </Link>
  );
}

export function MarketingHero({
  eyebrow,
  title,
  italicTail,
  lead,
  primaryCta,
  secondaryCta,
  accent,
  testId,
}: MarketingHeroProps) {
  return (
    <section
      className="surface-paper relative overflow-hidden border-b border-bone-200 pt-24 pb-14 md:pt-32 md:pb-18"
      data-testid={testId}
    >
      <div
        className="pointer-events-none absolute inset-0"
        aria-hidden="true"
        style={{
          background:
            "radial-gradient(ellipse 60% 50% at 10% 0%, color-mix(in srgb, var(--color-ochre-500) 12%, transparent), transparent 60%), radial-gradient(ellipse 55% 45% at 92% 100%, color-mix(in srgb, var(--color-jade-500) 9%, transparent), transparent 60%)",
        }}
      />
      <div className="container-elite relative">
        <div className={accent ? "grid items-end gap-10 lg:grid-cols-12" : ""}>
          <div className={accent ? "lg:col-span-7" : "max-w-3xl"}>
            <p className="eyebrow mb-5">{eyebrow}</p>
            <h1
              className="font-serif text-balance font-medium leading-[1.04] tracking-tight text-ink-900"
              style={{ fontSize: "clamp(40px, 6vw, 64px)" }}
            >
              {title}
              {italicTail ? (
                <>
                  {" "}
                  <span className="font-display-italic text-jade-500">{italicTail}</span>
                </>
              ) : null}
            </h1>
            {lead ? (
              <p className="mt-6 max-w-2xl text-[17px] leading-relaxed text-ink-700 md:text-[18px]">
                {lead}
              </p>
            ) : null}
            {primaryCta || secondaryCta ? (
              <div className="mt-8 flex flex-wrap gap-3">
                {primaryCta ? <CtaLink cta={primaryCta} variant="ink" /> : null}
                {secondaryCta ? <CtaLink cta={secondaryCta} variant="quiet" /> : null}
              </div>
            ) : null}
          </div>
          {accent ? <div className="lg:col-span-5">{accent}</div> : null}
        </div>
      </div>
    </section>
  );
}

export function MarketingClosingBand({
  eyebrow,
  title,
  lead,
  primaryCta,
  secondaryCta,
}: {
  eyebrow?: string;
  title: ReactNode;
  lead?: string;
  primaryCta: CtaSpec;
  secondaryCta?: CtaSpec;
}) {
  return (
    <section className="surface-ink border-t border-ink-700">
      <div className="container-elite section-padding">
        {eyebrow ? <p className="eyebrow mb-4 text-ochre-500">{eyebrow}</p> : null}
        <h2 className="font-serif text-balance text-3xl font-medium tracking-tight text-bone md:text-4xl">
          {title}
        </h2>
        {lead ? <p className="mt-4 max-w-xl text-bone/80">{lead}</p> : null}
        <div className="mt-8 flex flex-wrap gap-3">
          <CtaLink cta={primaryCta} variant="ochre" />
          {secondaryCta ? <CtaLink cta={secondaryCta} variant="quiet" /> : null}
        </div>
      </div>
    </section>
  );
}
