import type { Metadata } from "next";
import { MarketingHero } from "@/components/layout/marketing-hero";
import { platformFeePercent, platformFeeSummary } from "@/lib/fees";
import { SITE_NAME, SUPPORT_EMAIL, SUPPORT_MAILTO } from "@/lib/site";

export const metadata: Metadata = {
  title: "Terms of Service",
  description: `Terms for using ${SITE_NAME}, including fees, payment holds, disagreements, and refunds.`,
};

export default function TermsPage() {
  const fee = platformFeePercent();

  return (
    <>
      <MarketingHero
        eyebrow="Legal"
        title="Terms of Service"
        lead="Last updated: September 2026. These terms govern your use of Freelance Near Me."
      />
      <div className="container-elite py-16">
        <div className="prose-ink mx-auto max-w-3xl">
          <h2>1. Who operates the platform</h2>
          <p>
            {SITE_NAME} is the online marketplace at freelancenearme.com. Notices and support
            requests go to{" "}
            <a href={SUPPORT_MAILTO}>{SUPPORT_EMAIL}</a>. A registered company name and street
            address are available on request at that email. They are not printed here because they
            are not yet published on the site.
          </p>

          <h2>2. The service</h2>
          <p>
            {SITE_NAME} lets clients post jobs, search freelancers, receive proposals, enter
            contracts, and pay freelancers through milestone payments. The platform is aimed at
            people hiring and working in the United States. Prices are in US dollars. By creating
            an account or using the platform, you agree to these terms.
          </p>

          <h2>3. Accounts</h2>
          <p>
            You must provide accurate information when registering. You are responsible for
            activity under your account. We may suspend accounts that violate these terms or
            misuse the platform. Freelancers confirm an email address and complete Stripe payout
            setup before they can be hired. We do not perform a government ID check.
          </p>

          <h2>4. Contracts and payments</h2>
          <p>
            {SITE_NAME} facilitates introductions and payment processing. It is not a party to the
            contract between a client and a freelancer, and it is not a bank or a legal escrow
            provider. Clients fund milestones through Stripe. Those funds stay held until the
            client approves the work. Approval releases the payment to the freelancer.
          </p>
          <p>
            {platformFeeSummary()} Today that fee is {fee}%. The amount is shown again before you
            fund or release a milestone.
          </p>

          <h2>5. Disagreements</h2>
          <p>
            If you do not accept a delivery, do not approve the milestone. The funds stay held.
            Email {SUPPORT_EMAIL} with the contract ID and a short description of the problem. We
            will read the contract thread and help the two sides decide. We do not offer a
            separate mediation or arbitration service. You remain free to resolve a dispute under
            the law that applies to you.
          </p>

          <h2>6. Refunds</h2>
          <p>
            Unapproved milestones are not paid out. If you have not approved the work, contact
            support before you do. Once a milestone is approved and the payment is released to the
            freelancer, it is not refunded automatically. Any refund after release is decided case
            by case and, where Stripe allows it, processed through Stripe. The platform fee on a
            released milestone is not refunded unless we agree to that in writing.
          </p>

          <h2>7. Acceptable use</h2>
          <ul>
            <li>Do not post fraudulent jobs, profiles, or proposals</li>
            <li>Do not present example or test listings as real people or real clients</li>
            <li>Do not circumvent the platform to avoid fees on work sourced here</li>
            <li>Do not harass other users or share illegal content</li>
            <li>Comply with tax and employment laws that apply to you</li>
          </ul>

          <h2>8. Governing law</h2>
          <p>
            These terms are written for a US marketplace. Mandatory consumer protections in your
            place of residence still apply. Other questions of governing law follow the law that
            applies to the business operating {SITE_NAME}. Email {SUPPORT_EMAIL} if you need the
            operator&apos;s legal name for a formal notice.
          </p>

          <h2>9. Limitation of liability</h2>
          <p>
            The service is provided as-is. We are not liable for the quality of work delivered
            between users, or for losses from use of the platform, beyond the platform fees you
            paid us in the prior twelve months, except where the law does not allow that limit.
          </p>

          <h2>10. Changes</h2>
          <p>
            We may update these terms. Continued use after changes constitutes acceptance.
            Material changes will be communicated by email or an in-app notice.
          </p>
        </div>
      </div>
    </>
  );
}
