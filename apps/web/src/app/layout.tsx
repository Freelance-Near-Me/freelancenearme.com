import type { Metadata } from "next";
import { ClerkProvider } from "@clerk/nextjs";
import { Fraunces, Inter } from "next/font/google";
import { SpeedInsights } from "@vercel/speed-insights/next";
import { SiteHeader } from "@/components/site-header";
import { SiteFooter } from "@/components/layout/site-footer";
import { getClerkPublishableKey, isClerkConfigured } from "@/lib/env-clerk";
import "./globals.css";

const inter = Inter({ subsets: ["latin"], variable: "--font-sans" });
const fraunces = Fraunces({
  subsets: ["latin"],
  variable: "--font-serif",
});

export const metadata: Metadata = {
  title: "Freelance Near Me",
  description: "Hire freelancers near you — or anywhere. Post jobs, receive proposals, and manage contracts.",
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  const publishableKey = getClerkPublishableKey();
  const hasClerk = isClerkConfigured();

  const inner = (
    <>
      <SiteHeader />
      <main className="flex-1">{children}</main>
      <SiteFooter />
    </>
  );

  return (
    <html lang="en" className={`${inter.variable} ${fraunces.variable}`}>
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
