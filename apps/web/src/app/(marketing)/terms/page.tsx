import { MarketingHero } from "@/components/layout/marketing-hero";

export default function TermsPage() {
  return (
    <>
      <MarketingHero
        eyebrow="Legal"
        title="Terms of Service"
        lead="Last updated: July 2026. These terms govern your use of Freelance Near Me."
      />
      <div className="container-elite py-16">
        <div className="prose-ink mx-auto max-w-3xl">
          <h2>1. The service</h2>
          <p>
            Freelance Near Me provides an online marketplace where clients can post jobs,
            receive proposals, enter contracts, and pay freelancers through milestone-based
            escrow. By creating an account or using the platform, you agree to these terms.
          </p>

          <h2>2. Accounts</h2>
          <p>
            You must provide accurate information when registering. You are responsible for
            activity under your account. We may suspend accounts that violate these terms or
            misuse the platform.
          </p>

          <h2>3. Contracts and payments</h2>
          <p>
            Freelance Near Me facilitates connections and payment processing but is not a party
            to contracts between clients and freelancers. Milestone funds are held in escrow
            until the client approves release. Platform fees apply as shown at checkout.
          </p>

          <h2>4. Acceptable use</h2>
          <ul>
            <li>Do not post fraudulent jobs or proposals</li>
            <li>Do not circumvent the platform to avoid fees on work sourced here</li>
            <li>Do not harass other users or share illegal content</li>
            <li>Comply with applicable tax and employment laws in your jurisdiction</li>
          </ul>

          <h2>5. Limitation of liability</h2>
          <p>
            The service is provided as-is. We are not liable for disputes between users,
            quality of work delivered, or losses arising from use of the platform beyond
            amounts paid to us in the prior twelve months.
          </p>

          <h2>6. Changes</h2>
          <p>
            We may update these terms. Continued use after changes constitutes acceptance.
            Material changes will be communicated via email or in-app notice.
          </p>
        </div>
      </div>
    </>
  );
}
