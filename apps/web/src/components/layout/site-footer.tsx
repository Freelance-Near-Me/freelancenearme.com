import Link from "next/link";
import { platformFeePercent } from "@/lib/fees";
import { routes } from "@/lib/routes";
import { SUPPORT_EMAIL, SUPPORT_MAILTO } from "@/lib/site";

const footerLinks = {
  hire: [
    { label: "Find talent", href: routes.talents },
    { label: "Post a project", href: routes.postJob },
    { label: "How it works", href: "/how-it-works" },
    { label: "Trust centre", href: "/trust" },
  ],
  work: [
    { label: "Browse jobs", href: routes.jobs },
    { label: "Find work", href: routes.signUp("talent") },
    { label: "Saved searches", href: routes.savedSearches },
  ],
  trust: [
    { label: "Trust & verification", href: "/trust" },
    { label: "How it works", href: "/how-it-works" },
  ],
  company: [
    { label: "About", href: "/about" },
    { label: "Contact", href: "/contact" },
  ],
  legal: [
    { label: "Terms", href: "/terms" },
    { label: "Privacy", href: "/privacy" },
  ],
};

export function SiteFooter() {
  const year = new Date().getFullYear();

  return (
    <footer className="surface-paper mt-auto border-t border-bone-200">
      <div className="container-elite py-16">
        <div className="mb-14 max-w-3xl">
          <p className="eyebrow mb-3">Search by city or ZIP code</p>
          <p className="font-serif text-balance text-[28px] leading-[1.15] tracking-tight text-ink-900 md:text-[34px]">
            Search by ZIP code or city, interview before you hire, and keep payment held until
            you approve the work.
          </p>
        </div>

        <div className="mb-12 grid grid-cols-2 gap-10 md:grid-cols-6">
          <div className="col-span-2">
            <Link
              href={routes.home}
              className="font-serif text-xl font-medium tracking-tight text-ink-900"
            >
              Freelance Near Me
            </Link>
            <p className="mt-5 max-w-xs text-[14px] leading-relaxed text-ink-500">
              A US marketplace for hiring freelancers by city or ZIP code. Platform fee{" "}
              {platformFeePercent()}% when a milestone is released.
            </p>
          </div>

          {[
            { title: "Hire", items: footerLinks.hire },
            { title: "Work", items: footerLinks.work },
            { title: "Trust", items: footerLinks.trust },
            { title: "Company", items: footerLinks.company },
          ].map((col) => (
            <div key={col.title}>
              <p className="eyebrow mb-4">{col.title}</p>
              <ul className="space-y-2.5">
                {col.items.map((item) => (
                  <li key={item.href}>
                    <Link
                      href={item.href}
                      className="text-sm text-ink-700 transition hover:text-ink-900"
                    >
                      {item.label}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>

        <div className="flex flex-col items-start justify-between gap-4 border-t border-bone-200 pt-8 sm:flex-row sm:items-center">
          <p className="text-xs text-ink-500">
            © {year} Freelance Near Me.{" "}
            <a href={SUPPORT_MAILTO} className="hover:text-ink-900">
              {SUPPORT_EMAIL}
            </a>
          </p>
          <div className="flex gap-6">
            {footerLinks.legal.map((item) => (
              <Link
                key={item.href}
                href={item.href}
                className="text-xs text-ink-500 transition hover:text-ink-900"
              >
                {item.label}
              </Link>
            ))}
          </div>
        </div>
      </div>
    </footer>
  );
}
