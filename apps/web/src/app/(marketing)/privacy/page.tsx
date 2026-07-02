import { MarketingHero } from "@/components/layout/marketing-hero";

export default function PrivacyPage() {
  return (
    <>
      <MarketingHero
        eyebrow="Legal"
        title="Privacy Policy"
        lead="Last updated: July 2026. How we collect, use, and protect your data."
      />
      <div className="container-elite py-16">
        <div className="prose-ink mx-auto max-w-3xl">
          <h2>1. Information we collect</h2>
          <p>
            We collect account information (name, email, profile details), usage data,
            and payment-related metadata processed through Stripe. Authentication is handled
            by Clerk.
          </p>

          <h2>2. How we use information</h2>
          <ul>
            <li>Operate the marketplace (jobs, proposals, contracts, messaging)</li>
            <li>Process payments and prevent fraud</li>
            <li>Send transactional emails (proposals, offers, payments)</li>
            <li>Improve the product and comply with legal obligations</li>
          </ul>

          <h2>3. Sharing</h2>
          <p>
            We share data with service providers who help us run the platform: Clerk (auth),
            Stripe (payments), Resend (email), Vercel (hosting), and Neon (database).
            We do not sell your personal information.
          </p>

          <h2>4. Retention</h2>
          <p>
            We retain account and transaction records as long as needed to provide the service
            and meet legal requirements. You may request account deletion by contacting support.
          </p>

          <h2>5. Your rights</h2>
          <p>
            Depending on your location, you may have rights to access, correct, or delete your
            data. Contact us to exercise these rights.
          </p>

          <h2>6. Security</h2>
          <p>
            We use industry-standard practices including encrypted connections, secure payment
            processing, and access controls. No system is perfectly secure; report concerns
            promptly.
          </p>
        </div>
      </div>
    </>
  );
}
