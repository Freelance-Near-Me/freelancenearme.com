import type { Metadata } from "next";
import { ClerkProvider } from "@clerk/nextjs";
import { DM_Sans, Instrument_Serif } from "next/font/google";
import { SiteHeader } from "@/components/site-header";
import "./globals.css";

const dmSans = DM_Sans({ subsets: ["latin"], variable: "--font-sans" });
const instrumentSerif = Instrument_Serif({
  weight: "400",
  subsets: ["latin"],
  variable: "--font-serif",
});

export const dynamic = "force-dynamic";

export const metadata: Metadata = {
  title: "Freelance Near Me",
  description: "Hire freelancers near you — or anywhere. Post jobs, receive proposals, and manage contracts.",
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  const hasClerk = Boolean(process.env.NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY);

  const inner = (
    <>
      <SiteHeader />
      {children}
      <footer className="mt-auto border-t border-slate-200 bg-white py-8 text-center text-xs text-slate-500">
        © {new Date().getFullYear()} Freelance Near Me
      </footer>
    </>
  );

  return (
    <html lang="en" className={`${dmSans.variable} ${instrumentSerif.variable}`}>
      <body className="flex min-h-screen flex-col font-sans">
        {hasClerk ? <ClerkProvider>{inner}</ClerkProvider> : inner}
      </body>
    </html>
  );
}
