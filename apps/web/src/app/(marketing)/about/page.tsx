import { MarketingHero } from "@/components/layout/marketing-hero";
import { ButtonLink } from "@/components/ui/button";
import { routes } from "@/lib/routes";

export default function AboutPage() {
  return (
    <>
      <MarketingHero
        eyebrow="About"
        title="Freelance Near Me"
        lead="We connect businesses with skilled freelancers — locally or remotely."
      />
      <div className="container-elite py-16">
        <div className="prose-ink mx-auto max-w-3xl">
          <p>
            Freelance Near Me is a modern marketplace built with TypeScript, Next.js, and
            Tailwind on Vercel, with Postgres, Clerk for accounts, and Stripe for secure
            milestone payments.
          </p>
          <p>
            Our focus is a clear hire loop: discover talent, receive proposals, contract, and
            pay with confidence through escrow milestones and verified profiles.
          </p>
          <div className="mt-8">
            <ButtonLink href={routes.signUp("client")} variant="ink">
              Get started
            </ButtonLink>
          </div>
        </div>
      </div>
    </>
  );
}
