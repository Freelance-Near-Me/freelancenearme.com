"use client";

import Link from "next/link";
import { MenuIcon } from "lucide-react";
import { Show } from "@clerk/nextjs";
import { ButtonLink } from "@/components/ui/button";
import { Separator } from "@/components/ui/separator";
import {
  Sheet,
  SheetContent,
  SheetHeader,
  SheetTitle,
  SheetTrigger,
} from "@/components/ui/sheet";
import { routes } from "@/lib/routes";

const publicLinks = [
  { href: routes.talents, label: "Find talent" },
  { href: routes.jobs, label: "Find work" },
  { href: "/trust", label: "Trust" },
  { href: "/how-it-works", label: "How it works" },
];

export function MobileNav({ hasClerk }: { hasClerk: boolean }) {
  return (
    <Sheet>
      <SheetTrigger className="inline-flex h-8 items-center gap-1.5 rounded-lg border border-ink-900/18 px-3 text-sm font-medium text-ink-700 transition hover:bg-ink-900/5 md:hidden">
        <MenuIcon className="size-4" />
        Menu
      </SheetTrigger>
      <SheetContent side="right" className="w-[min(100%,20rem)]">
        <SheetHeader>
          <SheetTitle className="font-serif text-left">Menu</SheetTitle>
        </SheetHeader>
        <nav className="mt-4 flex flex-col gap-1" aria-label="Mobile">
          {publicLinks.map((l) => (
            <Link
              key={l.href}
              href={l.href}
              className="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-bone-50 hover:text-ink-900"
            >
              {l.label}
            </Link>
          ))}
          <Separator className="my-2" />
          {hasClerk ? (
            <>
              <Show when="signed-out">
                <Link
                  href={routes.signIn}
                  className="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700"
                >
                  Log in
                </Link>
                <ButtonLink href={routes.signUp("client")} variant="ink" className="mt-2">
                  Post a project
                </ButtonLink>
              </Show>
              <Show when="signed-in">
                <Link
                  href={routes.inbox}
                  className="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700"
                >
                  Inbox
                </Link>
                <Link
                  href={routes.notifications}
                  className="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700"
                >
                  Alerts
                </Link>
                <Link
                  href={routes.dashboard}
                  className="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700"
                >
                  Dashboard
                </Link>
              </Show>
            </>
          ) : (
            <Link
              href={routes.dashboard}
              className="rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700"
            >
              Dashboard
            </Link>
          )}
        </nav>
      </SheetContent>
    </Sheet>
  );
}
