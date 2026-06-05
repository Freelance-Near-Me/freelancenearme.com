import Link from "next/link";
import { Show, UserButton } from "@clerk/nextjs";
import { UserRole } from "@fnm/database";
import { prisma } from "@fnm/database";
import { getCurrentUser } from "@/lib/auth";
import { isClerkConfigured, isDatabaseConfigured } from "@/lib/env";
import { routes } from "@/lib/routes";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";

const publicLinks = [
  { href: routes.jobs, label: "Jobs" },
  { href: routes.talents, label: "Talent" },
  { href: routes.categories, label: "Categories" },
  { href: "/how-it-works", label: "How it works" },
];

async function unreadCount(userId: string) {
  try {
    return await prisma.notification.count({ where: { userId, read: false } });
  } catch {
    return 0;
  }
}

function NotificationBadge({ count }: { count: number }) {
  if (count <= 0) return null;
  return (
    <span className="absolute -right-2 -top-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-blue-600 px-1 text-[10px] font-bold text-white">
      {count > 9 ? "9+" : count}
    </span>
  );
}

export async function SiteHeader() {
  const hasClerk = isClerkConfigured();
  const user = isDatabaseConfigured() ? await getCurrentUser() : null;
  const unread = user ? await unreadCount(user.id) : 0;

  return (
    <header className="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur-md">
      <div className="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4">
        <Link href={routes.home} className="font-serif text-xl font-medium tracking-tight text-slate-900">
          Freelance Near Me
        </Link>

        <nav className="hidden items-center gap-5 md:flex" aria-label="Main">
          {publicLinks.map((l) => (
            <Link
              key={l.href}
              href={l.href}
              className="text-sm font-medium text-slate-600 transition hover:text-slate-900"
            >
              {l.label}
            </Link>
          ))}
        </nav>

        <div className="flex items-center gap-2 sm:gap-3">
          {hasClerk ? (
            <>
              <Show when="signed-out">
                <Link href={routes.signIn} className="hidden text-sm font-medium text-slate-600 sm:inline">
                  Log in
                </Link>
                <Link href={routes.signUp("client")}>
                  <Button>Get started</Button>
                </Link>
              </Show>
              <Show when="signed-in">
                <Link
                  href={routes.notifications}
                  className="relative hidden px-2 text-sm font-medium text-slate-600 sm:inline"
                >
                  Alerts
                  <NotificationBadge count={unread} />
                </Link>
                <Link href={routes.dashboard} className="hidden text-sm font-medium text-slate-600 md:inline">
                  Dashboard
                </Link>
                {user?.role === UserRole.CLIENT && (
                  <Link href={routes.postJob} className="hidden md:inline">
                    <Button variant="secondary">Post job</Button>
                  </Link>
                )}
                <UserButton />
              </Show>
            </>
          ) : (
            <>
              {user && (
                <Link href={routes.notifications} className="relative text-sm font-medium text-slate-600">
                  Alerts
                  <NotificationBadge count={unread} />
                </Link>
              )}
              <Link href={routes.dashboard} className="text-sm font-medium text-slate-600">
                Dashboard
              </Link>
            </>
          )}
        </div>
      </div>
    </header>
  );
}
