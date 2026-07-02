"use server";

import { prisma } from "@fnm/database";

export async function listProofClients() {
  try {
    return await prisma.proofClient.findMany({
      where: { active: true, permissionGranted: true },
      orderBy: [{ sortOrder: "asc" }, { name: "asc" }],
      select: {
        id: true,
        name: true,
        logoUrl: true,
        websiteUrl: true,
      },
    });
  } catch {
    return [];
  }
}

export async function getFeaturedTestimonial() {
  try {
    return await prisma.proofTestimonial.findFirst({
      where: { approved: true, featured: true },
      orderBy: [{ sortOrder: "desc" }, { updatedAt: "desc" }],
      select: {
        id: true,
        quote: true,
        authorName: true,
        authorTitle: true,
        authorInitials: true,
      },
    });
  } catch {
    return null;
  }
}
