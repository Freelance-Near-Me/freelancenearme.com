import { clerkMiddleware, createRouteMatcher } from "@clerk/nextjs/server";
import { NextResponse } from "next/server";

const isPublicRoute = createRouteMatcher([
  "/",
  "/sign-in(.*)",
  "/sign-up(.*)",
  "/jobs(.*)",
  "/talents(.*)",
  "/freelancers(.*)",
  "/about",
  "/how-it-works",
  "/api/health",
  "/api/webhooks(.*)",
]);

const hasClerk = Boolean(process.env.CLERK_SECRET_KEY);

export default hasClerk
  ? clerkMiddleware(async (auth, req) => {
      if (process.env.DEV_AUTH_BYPASS === "true") return;
      if (!isPublicRoute(req)) await auth.protect();
    })
  : function middleware() {
      return NextResponse.next();
    };

export const config = {
  matcher: [
    "/((?!_next|[^?]*\\.(?:html?|css|js(?!on)|jpe?g|webp|png|gif|svg|ttf|woff2?|ico|csv|docx?|xlsx?|zip|webmanifest)).*)",
    "/(api|trpc)(.*)",
  ],
};
