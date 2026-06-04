import mongoose from "mongoose";
import bcrypt from "bcryptjs";
import { env } from "./config/env.js";
import { User } from "./models/User.js";
import { Category } from "./models/Category.js";
import { Skill } from "./models/Skill.js";
import { Project } from "./models/Project.js";
import { SiteContent } from "./models/SiteContent.js";
import { toSlug } from "./utils/slug.js";

async function seed() {
  await mongoose.connect(env.mongoUri);
  console.log("Seeding database…");

  await Promise.all([
    User.deleteMany({}),
    Category.deleteMany({}),
    Skill.deleteMany({}),
    Project.deleteMany({}),
    SiteContent.deleteMany({}),
  ]);

  const categories = await Category.insertMany([
    { name: "Web Development", slug: "web-development", active: true },
    { name: "Design & Creative", slug: "design-creative", active: true },
    { name: "Writing & Translation", slug: "writing-translation", active: true },
    { name: "Marketing", slug: "marketing", active: true },
    { name: "Mobile Apps", slug: "mobile-apps", active: true },
  ]);

  const skills = await Skill.insertMany([
    { name: "React", slug: "react", categoryId: categories[0]._id, active: true },
    { name: "Node.js", slug: "node-js", categoryId: categories[0]._id, active: true },
    { name: "UI/UX Design", slug: "ui-ux-design", categoryId: categories[1]._id, active: true },
    { name: "SEO", slug: "seo", categoryId: categories[3]._id, active: true },
    { name: "Content Writing", slug: "content-writing", categoryId: categories[2]._id, active: true },
    { name: "React Native", slug: "react-native", categoryId: categories[4]._id, active: true },
  ]);

  const passwordHash = await bcrypt.hash("Password123!", 12);

  const employer = await User.create({
    username: "acme_corp",
    email: "employer@example.com",
    passwordHash,
    firstName: "Alex",
    lastName: "Morgan",
    accountType: "employer",
    country: "US",
    city: "Austin",
    verified: true,
    balance: 5000,
  });

  const freelancers = await User.insertMany([
    {
      username: "sarah_dev",
      email: "sarah@example.com",
      passwordHash,
      firstName: "Sarah",
      lastName: "Chen",
      accountType: "freelancer",
      country: "US",
      city: "San Francisco",
      headline: "Full-stack developer · React & Node",
      bio: "10+ years building SaaS products for startups and enterprises.",
      skills: [skills[0]._id, skills[1]._id],
      hourlyRate: 85,
      verified: true,
    },
    {
      username: "mike_design",
      email: "mike@example.com",
      passwordHash,
      firstName: "Mike",
      lastName: "Rivera",
      accountType: "freelancer",
      country: "CA",
      city: "Toronto",
      headline: "Product designer focused on conversion",
      bio: "I help brands ship polished interfaces that users love.",
      skills: [skills[2]._id],
      hourlyRate: 70,
      verified: true,
    },
  ]);

  await Project.insertMany([
    {
      employerId: employer._id,
      title: "Rebuild marketing site in Next.js",
      description:
        "We need a modern, fast marketing site with CMS integration, blog, and contact forms. Experience with headless CMS is a plus.",
      budgetMin: 3000,
      budgetMax: 6000,
      projectType: "fixed",
      environment: "remote",
      experienceLevel: "intermediate",
      categoryId: categories[0]._id,
      skills: [skills[0]._id, skills[1]._id],
      featured: true,
      country: "US",
    },
    {
      employerId: employer._id,
      title: "Ongoing SEO for local services brand",
      description:
        "Monthly SEO retainer: technical audits, content briefs, and rank tracking for 15 target cities.",
      budgetMin: 800,
      budgetMax: 1200,
      projectType: "hourly",
      environment: "remote",
      experienceLevel: "expert",
      categoryId: categories[3]._id,
      skills: [skills[3]._id, skills[4]._id],
      featured: false,
      country: "US",
    },
    {
      employerId: employer._id,
      title: "Mobile app UI polish pass",
      description:
        "Review existing React Native screens and deliver updated Figma files plus component specs.",
      budgetMin: 1500,
      budgetMax: 2500,
      projectType: "fixed",
      environment: "hybrid",
      experienceLevel: "intermediate",
      categoryId: categories[4]._id,
      skills: [skills[2]._id, skills[5]._id],
      featured: true,
      country: "US",
      city: "Austin",
    },
  ]);

  await SiteContent.insertMany([
    {
      slug: "about",
      title: "About Freelance Near Me",
      metaDescription: "Connect with local and remote freelancers near you.",
      body: `<p>Freelance Near Me helps businesses hire trusted freelancers and helps professionals find meaningful work nearby or remotely.</p>
<p>Our modern platform replaces legacy tooling with fast search, transparent budgets, and secure collaboration.</p>`,
    },
    {
      slug: "how-it-works",
      title: "How It Works",
      body: `<ol>
<li><strong>Post or browse</strong> — Employers post projects; freelancers browse open jobs.</li>
<li><strong>Connect</strong> — Review profiles, skills, and proposals.</li>
<li><strong>Collaborate</strong> — Work in project rooms with milestones and messaging (coming soon).</li>
<li><strong>Get paid</strong> — Secure payments via integrated checkout (Stripe integration planned).</li>
</ol>`,
    },
    {
      slug: "terms",
      title: "Terms & Conditions",
      body: `<p>By using Freelance Near Me you agree to our platform rules, fee schedule, and dispute process. Full legal text should be reviewed with counsel before production launch.</p>`,
    },
    {
      slug: "privacy",
      title: "Privacy Policy",
      body: `<p>We collect account information you provide at signup and usage data to improve the service. We do not sell personal data. Contact support for data requests.</p>`,
    },
  ]);

  console.log("Seed complete.");
  console.log("Demo logins (password: Password123!):");
  console.log("  Employer:   employer@example.com");
  console.log("  Freelancer: sarah@example.com");
  console.log(`  Freelancer: ${freelancers[1].email}`);
  console.log(`  Slugs use: ${toSlug("test")}`);

  await mongoose.disconnect();
}

seed().catch((err) => {
  console.error(err);
  process.exit(1);
});
