"use server";

import { prisma, UserRole } from "@fnm/database";
import { safeDbQuery } from "@/lib/db-safe";

export type TalentFilters = {
  q?: string;
  skill?: string;
  availability?: string;
  minRate?: number;
  maxRate?: number;
};

export async function listTalents(filters: TalentFilters = {}) {
  const { q, skill, availability, minRate, maxRate } = filters;

  return safeDbQuery(
    () =>
      prisma.user.findMany({
        where: {
          role: UserRole.TALENT,
          talentProfile: {
            is: {
              verified: true,
              ...(availability ? { availability } : {}),
              ...(minRate != null || maxRate != null
                ? {
                    hourlyRate: {
                      ...(minRate != null ? { gte: minRate } : {}),
                      ...(maxRate != null ? { lte: maxRate } : {}),
                    },
                  }
                : {}),
              ...(skill
                ? {
                    skills: {
                      some: { skill: { slug: skill } },
                    },
                  }
                : {}),
            },
          },
          ...(q
            ? {
                OR: [
                  { firstName: { contains: q, mode: "insensitive" } },
                  { lastName: { contains: q, mode: "insensitive" } },
                  { username: { contains: q, mode: "insensitive" } },
                  { talentProfile: { headline: { contains: q, mode: "insensitive" } } },
                ],
              }
            : {}),
        },
        include: {
          talentProfile: {
            include: {
              skills: { include: { skill: true } },
              portfolioItems: { take: 1, orderBy: { sortOrder: "asc" } },
            },
          },
          reviewsReceived: { select: { rating: true } },
        },
        take: 48,
        orderBy: { createdAt: "desc" },
      }),
    []
  );
}

export async function getTalentsBySkillSlug(skillSlug: string) {
  return listTalents({ skill: skillSlug });
}
