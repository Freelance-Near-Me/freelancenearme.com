import type { Metadata } from "next";
import { MarketingHero } from "@/components/layout/marketing-hero";
import { ButtonLink } from "@/components/ui/button";
import { SUPPORT_EMAIL, SUPPORT_MAILTO } from "@/lib/site";
import { routes } from "@/lib/routes";

export const metadata: Metadata = {
  title: "About",
  description:
    "Freelance Near Me is a US marketplace for hiring freelancers by city or ZIP code, with milestone payments held until you approve the work.",
};

export default function AboutPage() {
  return (
    <>
      <MarketingHero
        eyebrow="About"
        title="A marketplace for hiring"
        italicTail="someone specific"
        lead="Freelance Near Me helps US clients find a freelancer by city or ZIP code, talk to them, and pay only after the work is approved."
      />
      <div className="container-elite py-16">
        <div className="prose-ink mx-auto max-w-3xl">
          <p>
            Hiring from a pile of anonymous profiles makes it hard to know who will actually do the
            work. Freelance Near Me is built so you can search near a ZIP code or city, interview
            the person, and keep milestone payments held until you approve the delivery. Remote
            work is fine when local does not matter.
          </p>
          <p>
            Before a client can hire a freelancer, that freelancer confirms their email and
            finishes payout setup with Stripe. We do not run a government ID check. A public
            success score appears only after completed contracts and reviews.
          </p>
          <p>
            The site is published as Freelance Near Me at freelancenearme.com. For a question about
            the business, email{" "}
            <a href={SUPPORT_MAILTO} className="font-semibold text-ochre-700">
              {SUPPORT_EMAIL}
            </a>
            .
          </p>
          <div className="mt-8 flex flex-wrap gap-3">
            <ButtonLink href={routes.signUp("client")} variant="ink">
              Post a project
            </ButtonLink>
            <ButtonLink href="/contact" variant="secondary">
              Contact
            </ButtonLink>
          </div>
        </div>
      </div>
    </>
  );
}
