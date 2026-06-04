import "dotenv/config";
import {
  prisma,
  UserRole,
  JobStatus,
  BillingMode,
  WorkEnvironment,
  ExperienceLevel,
} from "../src/index.js";

function slugify(text: string) {
  return text
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "")
    .slice(0, 80);
}

async function main() {
  const skills = await Promise.all(
    ["React", "Node.js", "UI/UX Design", "SEO", "Content Writing", "React Native"].map(
      (name) =>
        prisma.skill.upsert({
          where: { slug: slugify(name) },
          create: { name, slug: slugify(name) },
          update: {},
        })
    )
  );

  const client = await prisma.user.upsert({
    where: { clerkId: "seed_client_1" },
    create: {
      clerkId: "seed_client_1",
      email: "client@demo.freelancenearme.com",
      username: "acme_corp",
      firstName: "Alex",
      lastName: "Morgan",
      role: UserRole.CLIENT,
      country: "US",
      city: "Austin",
      clientProfile: {
        create: {
          companyName: "Acme Corp",
          companySize: "11-50",
          verified: true,
        },
      },
    },
    update: {},
    include: { clientProfile: true },
  });

  const talent = await prisma.user.upsert({
    where: { clerkId: "seed_talent_1" },
    create: {
      clerkId: "seed_talent_1",
      email: "talent@demo.freelancenearme.com",
      username: "sarah_dev",
      firstName: "Sarah",
      lastName: "Chen",
      role: UserRole.TALENT,
      country: "US",
      city: "San Francisco",
      talentProfile: {
        create: {
          headline: "Full-stack developer · React & Node",
          bio: "10+ years building SaaS for startups.",
          hourlyRate: 85,
          verified: true,
          skills: {
            create: [
              { skillId: skills[0].id },
              { skillId: skills[1].id },
            ],
          },
        },
      },
    },
    update: {},
  });

  const jobs = [
    {
      title: "Rebuild marketing site in Next.js",
      description:
        "Modern marketing site with blog and contact forms. Headless CMS experience preferred.",
      budgetMin: 3000,
      budgetMax: 6000,
      billingMode: BillingMode.FIXED,
      featured: true,
    },
    {
      title: "Monthly SEO retainer for local brand",
      description: "Technical audits, content briefs, and rank tracking for 15 cities.",
      budgetMin: 800,
      budgetMax: 1200,
      billingMode: BillingMode.HOURLY,
      featured: false,
    },
  ];

  for (const j of jobs) {
    const slug = `${slugify(j.title)}-demo`;
    await prisma.job.upsert({
      where: { slug },
      create: {
        slug,
        posterId: client.id,
        title: j.title,
        description: j.description,
        status: JobStatus.OPEN,
        billingMode: j.billingMode,
        environment: WorkEnvironment.REMOTE,
        experienceLevel: ExperienceLevel.INTERMEDIATE,
        budgetMin: j.budgetMin,
        budgetMax: j.budgetMax,
        featured: j.featured,
        publishedAt: new Date(),
        skills: {
          create: [{ skillId: skills[0].id }, { skillId: skills[1].id }],
        },
      },
      update: {},
    });
  }

  console.log("Seed complete.");
  console.log("Demo users (map to Clerk in dev):");
  console.log("  Client:", client.email);
  console.log("  Talent:", talent.email);
}

main()
  .catch(console.error)
  .finally(() => prisma.$disconnect());
