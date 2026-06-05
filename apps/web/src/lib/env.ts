import { isDatabaseUrlConfigured, listConfiguredDatabaseEnvKeys, resolveDatabaseEnvKey } from "@fnm/database";

const CLERK_PUBLISHABLE_KEYS = [
  "NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY",
  "CLERK_PUBLISHABLE_KEY",
] as const;

const CLERK_SECRET_KEYS = ["CLERK_SECRET_KEY"] as const;

function firstSetEnv(keys: readonly string[]): string | undefined {
  for (const key of keys) {
    const value = process.env[key]?.trim();
    if (value) return key;
  }
  return undefined;
}

export function getClerkPublishableKey(): string | undefined {
  for (const key of CLERK_PUBLISHABLE_KEYS) {
    const value = process.env[key]?.trim();
    if (value) return value;
  }
  return undefined;
}

export function getClerkSecretKey(): string | undefined {
  return process.env.CLERK_SECRET_KEY?.trim() || undefined;
}

export function getClerkMissingKeys(): string[] {
  const missing: string[] = [];
  if (!getClerkPublishableKey()) missing.push("NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY");
  if (!getClerkSecretKey()) missing.push("CLERK_SECRET_KEY");
  return missing;
}

/** True when both Clerk keys are set (avoid half-configured Clerk breaking SSR). */
export function isClerkConfigured(): boolean {
  return getClerkMissingKeys().length === 0;
}

export function isDatabaseConfigured(): boolean {
  return isDatabaseUrlConfigured();
}

export function getDatabaseDiagnostics() {
  const keys = listConfiguredDatabaseEnvKeys();
  return {
    configured: isDatabaseUrlConfigured(),
    activeKey: resolveDatabaseEnvKey(),
    keysFound: keys,
  };
}

export function getClerkDiagnostics() {
  return {
    configured: isClerkConfigured(),
    publishableKeySet: Boolean(firstSetEnv(CLERK_PUBLISHABLE_KEYS)),
    secretKeySet: Boolean(firstSetEnv(CLERK_SECRET_KEYS)),
    missing: getClerkMissingKeys(),
  };
}

export function isDevAuthBypass(): boolean {
  return process.env.DEV_AUTH_BYPASS === "true" && process.env.NODE_ENV !== "production";
}
