/** Edge-safe env checks (no Prisma / Node database imports). */

/**
 * Next.js inlines only statically referenced process.env.* keys at build time.
 * Do not use process.env[variable] — dynamic lookups return undefined in production.
 */

export function getClerkPublishableKey(): string | undefined {
  return (
    process.env.NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY?.trim() ||
    process.env.CLERK_PUBLISHABLE_KEY?.trim() ||
    undefined
  );
}

export function getClerkSecretKey(): string | undefined {
  return process.env.CLERK_SECRET_KEY?.trim() || undefined;
}

/** Which Clerk-related env keys are set (names only — for /api/health). */
export function listClerkEnvKeysFound(): string[] {
  const found: string[] = [];
  if (process.env.NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY?.trim()) {
    found.push("NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY");
  }
  if (process.env.CLERK_PUBLISHABLE_KEY?.trim()) {
    found.push("CLERK_PUBLISHABLE_KEY");
  }
  if (process.env.CLERK_SECRET_KEY?.trim()) {
    found.push("CLERK_SECRET_KEY");
  }
  return found;
}

export function getClerkMissingKeys(): string[] {
  const missing: string[] = [];
  if (!getClerkPublishableKey()) {
    missing.push("NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY");
  }
  if (!getClerkSecretKey()) {
    missing.push("CLERK_SECRET_KEY");
  }
  return missing;
}

/** True when both Clerk keys are set (avoid half-configured Clerk breaking SSR). */
export function isClerkConfigured(): boolean {
  return getClerkMissingKeys().length === 0;
}

export function getClerkDiagnostics() {
  const keysFound = listClerkEnvKeysFound();
  const hasServerOnlyPublishable =
    Boolean(process.env.CLERK_PUBLISHABLE_KEY?.trim()) &&
    !process.env.NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY?.trim();

  return {
    configured: isClerkConfigured(),
    publishableKeySet: Boolean(getClerkPublishableKey()),
    secretKeySet: Boolean(getClerkSecretKey()),
    keysFound,
    missing: getClerkMissingKeys(),
    hint: hasServerOnlyPublishable
      ? "CLERK_PUBLISHABLE_KEY is set but NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY is required for the browser. Add NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY with the same pk_ value in Vercel → Production, then redeploy."
      : undefined,
  };
}

export function isDevAuthBypass(): boolean {
  return process.env.DEV_AUTH_BYPASS === "true" && process.env.NODE_ENV !== "production";
}
