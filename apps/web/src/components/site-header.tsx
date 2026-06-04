import Link from "next/link";
import { SignedIn, SignedOut, UserButton } from "@clerk/nextjs";
import { prisma } from "@fnm/database";
import { getCurrentUser } from "@/lib/auth";
import { cn } from "@/lib/utils";

const links = [
  { href: "/jobs", label: "Find jobs" },
  { href: "/talents", label: "Find talent" },
  { href: "/how-it-works", label: "How it works" },
];

export async function SiteHeader() {
  const hasClerk = Boolean(process.env.NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY);
  const user = await getCurrentUser();
  const unread =
    user != null
      ? await prisma.notification.count({
          where: { userId: user.id, read: false },
        })
      : 0;

  return (
    <header className="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
      <div className="mx-auto flex h-16 max-w-6xl items-center justify-between gap-6 px-4">
        <Link href="/" className="font-serif text-xl font-medium tracking-tight text-slate-900">
          Freelance Near Me
        </Link>
        <nav className="hidden items-center gap-6 md:flex">
          {links.map((l) => (
            <Link
              key={l.href}
              href={l.href}
              className="text-sm font-medium text-slate-600 hover:text-slate-900"
            >
              {l.label}
            </Link>
          ))}
        </nav>
        <div className="flex items-center gap-3">
          {hasClerk ? (
            <>
              <SignedOut>
                <Link href="/sign-in" className="text-sm font-medium text-slate-600">
                  Log in
                </Link>
                <Link
                  href="/sign-up?role=client"
                  className={cn(
                    "rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white",
                    "hover:bg-blue-700"
                  )}
                >
                  Get started
                </Link>
              </SignedOut>
              <SignedIn>
                <Link
                  href="/notifications"
                  className="relative hidden text-sm font-medium text-slate-600 sm:inline"
                >
                  Notifications
                  {unread > 0 && (
                    <span className="absolute -right-3 -top-2 flex h-4 min-w-4 items-center justify-center rounded-full bg-blue-600 px-1 text-[10px] font-bold text-white">
                      {unread > 9 ? "9+" : unread}
                    </span>
                  )}
                </Link>
                <Link href="/dashboard" className="hidden text-sm font-medium text-slate-600 sm:inline">
                  Dashboard
                </Link>
                <Link href="/profile" className="hidden text-sm font-medium text-slate-600 sm:inline">
                  Profile
                </Link>
                <UserButton afterSignOutUrl="/" />
              </SignedIn>
            </>
          ) : (
            <>
              {user && (
                <Link
                  href="/notifications"
                  className="relative text-sm font-medium text-slate-600"
                >
                  Notifications
                  {unread > 0 && (
                    <span className="ml-1 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-blue-600 px-1 text-[10px] font-bold text-white">
                      {unread > 9 ? "9+" : unread}
                    </span>
                  )}
                </Link>
              )}
              <Link href="/dashboard" className="text-sm font-medium text-slate-600">
                Dashboard (dev)
              </Link>
            </>
          )}
        </div>
      </div>
    </header>
  );
}
