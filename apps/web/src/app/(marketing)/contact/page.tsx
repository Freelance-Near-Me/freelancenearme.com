import { MarketingHero } from "@/components/layout/marketing-hero";

export default function ContactPage() {
  return (
    <>
      <MarketingHero
        eyebrow="Contact"
        title="Get in touch"
        lead="Questions about hiring, payouts, or your account? We are here to help."
      />
      <div className="container-elite py-16">
        <div className="prose-ink mx-auto max-w-xl">
          <p>
            Email us at{" "}
            <a href="mailto:support@freelancenearme.com" className="font-semibold text-ochre-700">
              support@freelancenearme.com
            </a>{" "}
            and we will respond within two business days.
          </p>
          <p>
            For payment or payout issues, include your contract ID and the milestone title
            so we can investigate quickly.
          </p>
        </div>
      </div>
    </>
  );
}
