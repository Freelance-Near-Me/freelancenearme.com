import Link from "next/link";
import { Show, UserButton } from "@clerk/nextjs";
import { UserRole } from "@fnm/database";
import { prisma } from "@fnm/database";
import { getCurrentUser } from "@/lib/auth";
import { isClerkConfigured, isDatabaseConfigured } from "@/lib/env";
import { getUnreadMessageCount } from "@/actions/inbox";
import { routes } from "@/lib/routes";
import { ButtonLink } from "@/components/ui/button";

const publicLinks = [
  { href: routes.talents, label: "Find talent" },
  { href: routes.jobs, label: "Find work" },
  { href: "/trust", label: "Trust" },
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
    <span className="absolute -right-2 -top-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-ochre-500 px-1 text-[10px] font-bold text-ink-900">
      {count > 9 ? "9+" : count}
    </span>
  );
}

export async function SiteHeader() {
  const hasClerk = isClerkConfigured();
  const user = isDatabaseConfigured() ? await getCurrentUser() : null;
  const [unread, unreadMessages] = user
    ? await Promise.all([unreadCount(user.id), getUnreadMessageCount(user.id)])
    : [0, 0];

  return (
    <header className="sticky top-0 z-50 border-b border-bone-200/80 bg-bone/95 backdrop-blur-md">
      <div className="container-elite flex h-16 items-center justify-between gap-4">
        <Link
          href={routes.home}
          className="font-serif text-xl font-medium tracking-tight text-ink-900"
        >
          Freelance Near Me
        </Link>

        <nav className="hidden items-center gap-5 md:flex" aria-label="Main">
          {publicLinks.map((l) => (
            <Link
              key={l.href}
              href={l.href}
              className="text-sm font-medium text-ink-700 transition hover:text-ink-900"
            >
              {l.label}
            </Link>
          ))}
        </nav>

        <details className="relative md:hidden">
          <summary className="cursor-pointer list-none rounded-lg border border-bone-200 px-3 py-1.5 text-sm font-medium text-ink-700 [&::-webkit-details-marker]:hidden">
            Menu
          </summary>
          <div className="absolute right-0 z-50 mt-2 flex w-56 flex-col gap-2 rounded-xl border border-bone-200 bg-white p-3 shadow-lg">
            {publicLinks.map((l) => (
              <Link key={l.href} href={l.href} className="text-sm font-medium text-ink-700">
                {l.label}
              </Link>
            ))}
            {hasClerk ? (
              <>
                <Show when="signed-out">
                  <Link href={routes.signIn} className="text-sm font-medium text-ink-700">
                    Log in
                  </Link>
                  <ButtonLink href={routes.signUp("client")} variant="ink">
                    Post a project
                  </ButtonLink>
                </Show>
                <Show when="signed-in">
                  <Link href={routes.inbox} className="text-sm font-medium text-ink-700">
                    Inbox
                  </Link>
                  <Link href={routes.notifications} className="text-sm font-medium text-ink-700">
                    Alerts
                  </Link>
                  <Link href={routes.dashboard} className="text-sm font-medium text-ink-700">
                    Dashboard
                  </Link>
                </Show>
              </>
            ) : (
              <Link href={routes.dashboard} className="text-sm font-medium text-ink-700">
                Dashboard
              </Link>
            )}
          </div>
        </details>

        <div className="hidden items-center gap-2 md:flex md:gap-3">
          {hasClerk ? (
            <>
              <Show when="signed-out">
                <Link
                  href={routes.signIn}
                  className="hidden text-sm font-medium text-ink-700 sm:inline"
                >
                  Log in
                </Link>
                <ButtonLink href={routes.talents} variant="quiet" className="hidden sm:inline-flex">
                  Browse talent
                </ButtonLink>
                <ButtonLink href={routes.signUp("client")} variant="ink">
                  Post a project
                </ButtonLink>
              </Show>
              <Show when="signed-in">
                <Link
                  href={routes.inbox}
                  className="relative hidden px-2 text-sm font-medium text-ink-700 sm:inline"
                >
                  Inbox
                  <NotificationBadge count={unreadMessages} />
                </Link>
                <Link
                  href={routes.notifications}
                  className="relative hidden px-2 text-sm font-medium text-ink-700 sm:inline"
                >
                  Alerts
                  <NotificationBadge count={unread} />
                </Link>
                <Link
                  href={routes.dashboard}
                  className="hidden text-sm font-medium text-ink-700 md:inline"
                >
                  Dashboard
                </Link>
                {user?.role === UserRole.CLIENT && (
                  <ButtonLink href={routes.postJob} variant="quiet" className="hidden md:inline-flex">
                    Post job
                  </ButtonLink>
                )}
                <UserButton />
              </Show>
            </>
          ) : (
            <>
              {user && (
                <Link
                  href={routes.notifications}
                  className="relative text-sm font-medium text-ink-700"
                >
                  Alerts
                  <NotificationBadge count={unread} />
                </Link>
              )}
              <Link href={routes.dashboard} className="text-sm font-medium text-ink-700">
                Dashboard
              </Link>
            </>
          )}
        </div>
      </div>
    </header>
  );
}
