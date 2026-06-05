/**
 * Resolve Postgres URL from standard or Vercel/Neon integration env names.
 * Prefer DATABASE_URL; fall back to Neon template vars when linked on Vercel.
 */
export function resolveDatabaseUrl(): string | undefined {
  const raw =
    process.env.DATABASE_URL?.trim() ||
    process.env.POSTGRES_PRISMA_URL?.trim() ||
    process.env.POSTGRES_URL?.trim();

  if (!raw) return undefined;

  try {
    const url = new URL(raw.replace(/^postgresql:/, "postgres:"));
    if (url.hostname.includes("-pooler") && !url.searchParams.has("pgbouncer")) {
      url.searchParams.set("pgbouncer", "true");
    }
    // pg driver on Vercel can choke on Neon's channel_binding param
    url.searchParams.delete("channel_binding");
    return url.toString().replace(/^postgres:/, "postgresql:");
  } catch {
    return raw;
  }
}
