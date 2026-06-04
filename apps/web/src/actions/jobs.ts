"use server";

import {
  prisma,
  JobStatus,
  UserRole,
  type BillingMode,
  type WorkEnvironment,
  type ExperienceLevel,
} from "@fnm/database";
import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";
import { z } from "zod";
import { requireRole, requireUser } from "@/lib/auth";
import { uniqueSlug } from "@/lib/slug";

const jobSchema = z.object({
  title: z.string().min(5).max(200),
  description: z.string().min(20),
  budgetMin: z.coerce.number().min(0),
  budgetMax: z.coerce.number().min(0),
  billingMode: z.enum(["FIXED", "HOURLY"]),
  environment: z.enum(["REMOTE", "ONSITE", "HYBRID"]),
  experienceLevel: z.enum(["ENTRY", "INTERMEDIATE", "EXPERT"]),
  country: z.string().optional(),
  city: z.string().optional(),
  skillIds: z.array(z.string()).optional(),
});

function parseJobForm(formData: FormData) {
  const skillIds = formData.getAll("skillIds").map(String).filter(Boolean);
  return jobSchema.safeParse({
    title: formData.get("title"),
    description: formData.get("description"),
    budgetMin: formData.get("budgetMin"),
    budgetMax: formData.get("budgetMax"),
    billingMode: formData.get("billingMode"),
    environment: formData.get("environment"),
    experienceLevel: formData.get("experienceLevel"),
    country: formData.get("country") || undefined,
    city: formData.get("city") || undefined,
    skillIds,
  });
}

async function syncJobSkills(jobId: string, skillIds?: string[]) {
  await prisma.jobSkill.deleteMany({ where: { jobId } });
  if (skillIds?.length) {
    await prisma.jobSkill.createMany({
      data: skillIds.map((skillId) => ({ jobId, skillId })),
      skipDuplicates: true,
    });
  }
}

export async function createJob(formData: FormData) {
  const user = await requireRole(UserRole.CLIENT);
  const parsed = parseJobForm(formData);
  if (!parsed.success) throw new Error("Invalid job data");
  const d = parsed.data;
  if (d.budgetMax < d.budgetMin) throw new Error("Max budget must be ≥ min budget");

  const publish = formData.get("publish") === "true";
  const slug = uniqueSlug(d.title, user.id);

  const job = await prisma.job.create({
    data: {
      slug,
      posterId: user.id,
      title: d.title,
      description: d.description,
      status: publish ? JobStatus.OPEN : JobStatus.DRAFT,
      billingMode: d.billingMode as BillingMode,
      environment: d.environment as WorkEnvironment,
      experienceLevel: d.experienceLevel as ExperienceLevel,
      budgetMin: d.budgetMin,
      budgetMax: d.budgetMax,
      country: d.country ?? user.country,
      city: d.city ?? user.city,
      publishedAt: publish ? new Date() : null,
    },
  });

  await syncJobSkills(job.id, d.skillIds);
  revalidatePath("/jobs");
  redirect(`/jobs/${job.slug}`);
}

export async function updateJob(slug: string, formData: FormData): Promise<void> {
  const user = await requireRole(UserRole.CLIENT);
  const job = await prisma.job.findUnique({ where: { slug } });
  if (!job || job.posterId !== user.id) throw new Error("Not authorized");

  const parsed = parseJobForm(formData);
  if (!parsed.success) throw new Error("Invalid job data");
  const d = parsed.data;
  if (d.budgetMax < d.budgetMin) throw new Error("Max budget must be ≥ min budget");

  const publish = formData.get("publish") === "true";

  await prisma.job.update({
    where: { id: job.id },
    data: {
      title: d.title,
      description: d.description,
      billingMode: d.billingMode as BillingMode,
      environment: d.environment as WorkEnvironment,
      experienceLevel: d.experienceLevel as ExperienceLevel,
      budgetMin: d.budgetMin,
      budgetMax: d.budgetMax,
      country: d.country,
      city: d.city,
      ...(publish
        ? { status: JobStatus.OPEN, publishedAt: job.publishedAt ?? new Date() }
        : {}),
    },
  });

  await syncJobSkills(job.id, d.skillIds);
  revalidatePath("/jobs");
  revalidatePath(`/jobs/${slug}`);
  redirect(`/jobs/${slug}`);
}

export async function publishJob(slug: string): Promise<void> {
  const user = await requireRole(UserRole.CLIENT);
  const job = await prisma.job.findUnique({ where: { slug } });
  if (!job || job.posterId !== user.id) throw new Error("Not authorized");

  await prisma.job.update({
    where: { id: job.id },
    data: { status: JobStatus.OPEN, publishedAt: new Date() },
  });

  revalidatePath("/jobs");
  redirect(`/jobs/${slug}`);
}

export async function listOpenJobs(query?: string) {
  return prisma.job.findMany({
    where: {
      status: JobStatus.OPEN,
      ...(query
        ? {
            OR: [
              { title: { contains: query, mode: "insensitive" } },
              { description: { contains: query, mode: "insensitive" } },
            ],
          }
        : {}),
    },
    include: {
      poster: { select: { firstName: true, lastName: true, username: true, country: true, city: true } },
      skills: { include: { skill: true } },
      _count: { select: { proposals: true } },
    },
    orderBy: [{ featured: "desc" }, { publishedAt: "desc" }],
    take: 50,
  });
}

export async function getJobBySlug(slug: string) {
  return prisma.job.findUnique({
    where: { slug },
    include: {
      poster: { select: { id: true, firstName: true, lastName: true, username: true, country: true, city: true } },
      skills: { include: { skill: true } },
      proposals: {
        include: {
          talent: {
            select: {
              id: true,
              firstName: true,
              lastName: true,
              username: true,
              talentProfile: true,
            },
          },
        },
        orderBy: { createdAt: "desc" },
      },
    },
  });
}

export async function getMyJobs() {
  const user = await requireUser();
  return prisma.job.findMany({
    where: { posterId: user.id },
    orderBy: { createdAt: "desc" },
    include: {
      skills: { include: { skill: true } },
      _count: { select: { proposals: true } },
    },
  });
}
