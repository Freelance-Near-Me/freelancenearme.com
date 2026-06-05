import { NextResponse } from "next/server";
import { isClerkConfigured, isDatabaseConfigured } from "@/lib/env";

export async function GET() {
  let database = "not_configured" as "ok" | "error" | "not_configured";

  if (isDatabaseConfigured()) {
    try {
      const { prisma } = await import("@fnm/database");
      await prisma.$queryRaw`SELECT 1`;
      database = "ok";
    } catch {
      database = "error";
    }
  }

  const ok = database === "ok";

  return NextResponse.json(
    {
      ok,
      app: "freelancenearme-web",
      database,
      clerk: isClerkConfigured() ? "configured" : "not_configured",
    },
    { status: ok ? 200 : 503 }
  );
}
