import type { Metadata } from "next";
import { MarketingHero } from "@/components/layout/marketing-hero";
import { ContactForm } from "@/components/contact-form";
import { SITE_NAME, SUPPORT_EMAIL, SUPPORT_MAILTO } from "@/lib/site";

export const metadata: Metadata = {
  title: "Contact",
  description: `Contact ${SITE_NAME} about hiring, payouts, or your account.`,
};

export default function ContactPage() {
  return (
    <>
      <MarketingHero
        eyebrow="Contact"
        title="Get in touch"
        lead="Questions about hiring, payouts, or your account? Send a message and we will reply within two business days."
      />
      <div className="container-elite py-16">
        <div className="mx-auto grid max-w-5xl gap-12 md:grid-cols-2">
          <div className="prose-ink">
            <h2>Freelance Near Me</h2>
            <p>
              {SITE_NAME} is the business name on this website. Write to{" "}
              <a href={SUPPORT_MAILTO} className="font-semibold text-ochre-700">
                {SUPPORT_EMAIL}
              </a>
              .
            </p>
            <p>
              A street address is not published here. If you need it for a notice or a payment
              question, ask by email and include the contract ID and milestone title.
            </p>
          </div>
          <ContactForm />
        </div>
      </div>
    </>
  );
}
