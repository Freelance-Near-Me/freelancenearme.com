import type { Metadata } from "next";
import { ClerkProvider } from "@clerk/nextjs";
import { Fraunces, Geist } from "next/font/google";
import { SpeedInsights } from "@vercel/speed-insights/next";
import { SiteHeader } from "@/components/site-header";
import { SiteFooter } from "@/components/layout/site-footer";
import { Toaster } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { getClerkPublishableKey, isClerkConfigured } from "@/lib/env-clerk";
import { cn } from "@/lib/utils";
import "./globals.css";

const geist = Geist({ subsets: ["latin"], variable: "--font-sans" });
const fraunces = Fraunces({
  subsets: ["latin"],
  variable: "--font-serif",
});

export const metadata: Metadata = {
  title: {
    default: "Freelance Near Me",
    template: "%s · Freelance Near Me",
  },
  description:
    "Hire freelancers in the US by city or ZIP code. Email and payout checks before hire. Milestone payments stay held until you approve the work.",
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  const publishableKey = getClerkPublishableKey();
  const hasClerk = isClerkConfigured();

  const inner = (
    <TooltipProvider>
      <SiteHeader />
      <main className="flex-1">{children}</main>
      <SiteFooter />
      <Toaster richColors closeButton position="top-right" />
    </TooltipProvider>
  );

  return (
    <html lang="en" className={cn(geist.variable, fraunces.variable, "font-sans")}>
      <body className="flex min-h-screen flex-col font-sans">
        {hasClerk && publishableKey ? (
          <ClerkProvider publishableKey={publishableKey}>{inner}</ClerkProvider>
        ) : (
          inner
        )}
        <SpeedInsights />
      </body>
    </html>
  );
}
