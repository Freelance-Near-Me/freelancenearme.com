"use server";

import { prisma } from "@fnm/database";
import { safeDbQuery } from "@/lib/db-safe";
import { LEGACY_CATEGORY_SLUGS, publicOpenJobWhere } from "@/lib/listing-visibility";

export async function listCategories() {
  const categories = await safeDbQuery(
    () =>
      prisma.category.findMany({
        where: { parentId: null },
        include: {
          children: { orderBy: { sortOrder: "asc" } },
          _count: { select: { jobs: { where: publicOpenJobWhere() } } },
        },
        orderBy: { sortOrder: "asc" },
      }),
    []
  );

  const bySlug = new Map(categories.map((category) => [category.slug, { ...category, _count: { ...category._count } }]));
  for (const [legacySlug, canonicalSlug] of Object.entries(LEGACY_CATEGORY_SLUGS)) {
    const legacy = bySlug.get(legacySlug);
    const canonical = bySlug.get(canonicalSlug);
    if (!legacy || !canonical) continue;
    canonical._count.jobs += legacy._count.jobs;
    bySlug.delete(legacySlug);
  }

  return [...bySlug.values()].sort((a, b) => a.sortOrder - b.sortOrder || a.name.localeCompare(b.name));
}

export async function getCategoryBySlug(slug: string) {
  return safeDbQuery(
    () =>
      prisma.category.findUnique({
        where: { slug },
        include: {
          parent: true,
          children: { orderBy: { sortOrder: "asc" } },
          skills: { orderBy: { sortOrder: "asc" } },
        },
      }),
    null
  );
}
