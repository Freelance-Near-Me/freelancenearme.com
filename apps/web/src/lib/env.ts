/** True when both Clerk keys are set (avoid half-configured Clerk breaking SSR). */
export function isClerkConfigured(): boolean {
  return Boolean(
    process.env.CLERK_SECRET_KEY?.trim() &&
      process.env.NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY?.trim()
  );
}

export function isDatabaseConfigured(): boolean {
  return Boolean(
    process.env.DATABASE_URL?.trim() ||
      process.env.POSTGRES_PRISMA_URL?.trim() ||
      process.env.POSTGRES_URL?.trim()
  );
}

export function isDevAuthBypass(): boolean {
  return process.env.DEV_AUTH_BYPASS === "true" && process.env.NODE_ENV !== "production";
}
