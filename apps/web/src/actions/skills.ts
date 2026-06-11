"use server";

import { prisma } from "@fnm/database";

export async function listSkills() {
  return prisma.skill.findMany({ orderBy: [{ sortOrder: "asc" }, { name: "asc" }] });
}
