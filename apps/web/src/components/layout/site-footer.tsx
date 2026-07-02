import Link from "next/link";
import { routes } from "@/lib/routes";

const footerLinks = {
  hire: [
    { label: "Find talent", href: routes.talents },
    { label: "Post a job", href: routes.postJob },
    { label: "How it works", href: "/how-it-works" },
    { label: "Categories", href: routes.categories },
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
          <p className="eyebrow mb-3">Verified profiles, escrow milestones</p>
          <p className="font-serif text-balance text-[28px] leading-[1.15] tracking-tight text-ink-900 md:text-[34px]">
            The person you brief is the person who delivers. Fund work in escrow,
            review proposals, and pay only for milestones you accept.
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
              A modern marketplace for hiring freelancers locally or remotely.
              Post jobs, review proposals, and manage contracts in one place.
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
            © {year} Freelance Near Me. All rights reserved.
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
