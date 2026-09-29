import type { Prisma } from "@fnm/database";
import { JobStatus } from "@fnm/database";

/** Seed and test listings use this email domain or a `-demo` slug. */
export const DEMO_EMAIL_SUFFIX = "@demo.freelancenearme.com";
export const DEMO_SLUG_SUFFIX = "-demo";

/**
 * Older category names that duplicate the current taxonomy.
 * Public pages fold these into the canonical slug.
 */
export const LEGACY_CATEGORY_SLUGS: Record<string, string> = {
  development: "development-and-it",
  design: "design-and-creative",
  writing: "writing-and-translation",
};

export function hideDemoListings(): boolean {
  return process.env.VERCEL_ENV === "production";
}

export function canonicalCategorySlug(slug: string): string {
  return LEGACY_CATEGORY_SLUGS[slug] ?? slug;
}

/** Category slug plus any legacy slugs whose jobs should appear with it. */
export function slugsForCategory(slug: string): string[] {
  const canonical = canonicalCategorySlug(slug);
  const legacy = Object.entries(LEGACY_CATEGORY_SLUGS)
    .filter(([, target]) => target === canonical)
    .map(([oldSlug]) => oldSlug);
  return [canonical, ...legacy];
}

export function publicOpenJobWhere(): Prisma.JobWhereInput {
  const where: Prisma.JobWhereInput = { status: JobStatus.OPEN };
  if (!hideDemoListings()) return where;

  return {
    ...where,
    NOT: {
      OR: [
        { slug: { endsWith: DEMO_SLUG_SUFFIX } },
        { poster: { email: { endsWith: DEMO_EMAIL_SUFFIX } } },
      ],
    },
  };
}
