import { Router } from "express";
import { z } from "zod";
import { Project } from "../models/Project.js";
import { requireAuth, requireEmployer, type AuthenticatedRequest } from "../middleware/auth.js";

const router = Router();

const listQuerySchema = z.object({
  q: z.string().optional(),
  skills: z.string().optional(),
  category: z.string().optional(),
  projectType: z.enum(["fixed", "hourly"]).optional(),
  environment: z.enum(["remote", "onsite", "hybrid"]).optional(),
  minBudget: z.coerce.number().optional(),
  maxBudget: z.coerce.number().optional(),
  page: z.coerce.number().min(1).default(1),
  limit: z.coerce.number().min(1).max(50).default(12),
});

const createProjectSchema = z.object({
  title: z.string().min(5).max(200),
  description: z.string().min(20).max(10000),
  budgetMin: z.number().min(0),
  budgetMax: z.number().min(0),
  projectType: z.enum(["fixed", "hourly"]).default("fixed"),
  environment: z.enum(["remote", "onsite", "hybrid"]).default("remote"),
  experienceLevel: z.enum(["entry", "intermediate", "expert"]).default("intermediate"),
  categoryId: z.string().optional(),
  skills: z.array(z.string()).default([]),
  country: z.string().optional(),
  city: z.string().optional(),
});

router.get("/", async (req, res) => {
  const parsed = listQuerySchema.safeParse(req.query);
  if (!parsed.success) {
    return res.status(400).json({ error: "Invalid query", details: parsed.error.flatten() });
  }

  const { q, skills, category, projectType, environment, minBudget, maxBudget, page, limit } =
    parsed.data;

  const filter: Record<string, unknown> = {
    visibility: "public",
    status: "open",
  };

  if (q) {
    filter.$text = { $search: q };
  }
  if (skills) {
    filter.skills = { $in: skills.split(",") };
  }
  if (category) {
    filter.categoryId = category;
  }
  if (projectType) filter.projectType = projectType;
  if (environment) filter.environment = environment;
  if (minBudget !== undefined) filter.budgetMin = { $gte: minBudget };
  if (maxBudget !== undefined) filter.budgetMax = { $lte: maxBudget };

  const skip = (page - 1) * limit;

  const [items, total] = await Promise.all([
    Project.find(filter)
      .populate("employerId", "firstName lastName country city username verified")
      .populate("skills", "name slug")
      .populate("categoryId", "name slug")
      .sort({ featured: -1, createdAt: -1 })
      .skip(skip)
      .limit(limit)
      .lean(),
    Project.countDocuments(filter),
  ]);

  return res.json({
    items,
    pagination: { page, limit, total, pages: Math.ceil(total / limit) },
  });
});

router.get("/mine/list", requireAuth, requireEmployer, async (req: AuthenticatedRequest, res) => {
  const projects = await Project.find({ employerId: req.user!._id })
    .sort({ createdAt: -1 })
    .populate("skills", "name slug")
    .lean();

  return res.json({ projects });
});

router.get("/:id", async (req, res) => {
  const project = await Project.findById(req.params.id)
    .populate("employerId", "firstName lastName country city username verified headline")
    .populate("skills", "name slug")
    .populate("categoryId", "name slug")
    .lean();

  if (!project) {
    return res.status(404).json({ error: "Project not found" });
  }

  return res.json({ project });
});

router.post("/", requireAuth, requireEmployer, async (req: AuthenticatedRequest, res) => {
  const parsed = createProjectSchema.safeParse(req.body);
  if (!parsed.success) {
    return res.status(400).json({ error: "Validation failed", details: parsed.error.flatten() });
  }

  const data = parsed.data;
  if (data.budgetMax < data.budgetMin) {
    return res.status(400).json({ error: "Maximum budget must be >= minimum budget" });
  }

  if (!req.user!.verified) {
    return res.status(403).json({ error: "Account must be verified before posting jobs" });
  }

  const project = await Project.create({
    employerId: req.user!._id,
    title: data.title,
    description: data.description,
    budgetMin: data.budgetMin,
    budgetMax: data.budgetMax,
    projectType: data.projectType,
    environment: data.environment,
    experienceLevel: data.experienceLevel,
    categoryId: data.categoryId,
    skills: data.skills,
    country: data.country ?? req.user!.country,
    city: data.city ?? req.user!.city,
  });

  const populated = await Project.findById(project._id)
    .populate("employerId", "firstName lastName username")
    .populate("skills", "name slug")
    .lean();

  return res.status(201).json({ project: populated });
});

export default router;
