import { Router } from "express";
import { z } from "zod";
import { User } from "../models/User.js";

const router = Router();

const listQuerySchema = z.object({
  q: z.string().optional(),
  skills: z.string().optional(),
  country: z.string().optional(),
  city: z.string().optional(),
  page: z.coerce.number().min(1).default(1),
  limit: z.coerce.number().min(1).max(50).default(12),
});

router.get("/", async (req, res) => {
  const parsed = listQuerySchema.safeParse(req.query);
  if (!parsed.success) {
    return res.status(400).json({ error: "Invalid query" });
  }

  const { q, skills, country, city, page, limit } = parsed.data;
  const filter: Record<string, unknown> = {
    accountType: "freelancer",
    verified: true,
  };

  if (country) filter.country = country;
  if (city) filter.city = city;
  if (skills) filter.skills = { $in: skills.split(",") };

  if (q) {
    filter.$or = [
      { firstName: { $regex: q, $options: "i" } },
      { lastName: { $regex: q, $options: "i" } },
      { username: { $regex: q, $options: "i" } },
      { headline: { $regex: q, $options: "i" } },
      { bio: { $regex: q, $options: "i" } },
    ];
  }

  const skip = (page - 1) * limit;

  const [items, total] = await Promise.all([
    User.find(filter)
      .select("-passwordHash -email -balance")
      .populate("skills", "name slug")
      .sort({ createdAt: -1 })
      .skip(skip)
      .limit(limit)
      .lean(),
    User.countDocuments(filter),
  ]);

  return res.json({
    items,
    pagination: { page, limit, total, pages: Math.ceil(total / limit) },
  });
});

router.get("/:id", async (req, res) => {
  const talent = await User.findOne({
    _id: req.params.id,
    accountType: "freelancer",
  })
    .select("-passwordHash -email -balance")
    .populate("skills", "name slug")
    .lean();

  if (!talent) {
    return res.status(404).json({ error: "Talent not found" });
  }

  return res.json({ talent });
});

export default router;
