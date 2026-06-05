"use server";

import { prisma } from "@fnm/database";
import { safeDbQuery } from "@/lib/db-safe";

export async function listCategories() {
  return safeDbQuery(
    () =>
      prisma.category.findMany({
        where: { parentId: null },
        include: {
          children: { orderBy: { sortOrder: "asc" } },
          _count: { select: { jobs: true } },
        },
        orderBy: { sortOrder: "asc" },
      }),
    []
  );
}

export async function getCategoryBySlug(slug: string) {
  return safeDbQuery(
    () =>
      prisma.category.findUnique({
        where: { slug },
        include: {
          parent: true,
          children: { orderBy: { sortOrder: "asc" } },
          skills: { orderBy: { name: "asc" } },
        },
      }),
    null
  );
}
