import { Router } from "express";
import { Category } from "../models/Category.js";
import { Skill } from "../models/Skill.js";
import { SiteContent } from "../models/SiteContent.js";

const router = Router();

router.get("/categories", async (_req, res) => {
  const categories = await Category.find({ active: true, parentId: null })
    .sort({ name: 1 })
    .lean();
  return res.json({ categories });
});

router.get("/skills", async (_req, res) => {
  const skills = await Skill.find({ active: true, parentId: null })
    .sort({ name: 1 })
    .lean();
  return res.json({ skills });
});

router.get("/pages/:slug", async (req, res) => {
  const page = await SiteContent.findOne({ slug: req.params.slug }).lean();
  if (!page) {
    return res.status(404).json({ error: "Page not found" });
  }
  return res.json({ page });
});

router.get("/home", async (_req, res) => {
  const [categories, skills, stats] = await Promise.all([
    Category.find({ active: true, parentId: null }).limit(8).lean(),
    Skill.find({ active: true, parentId: null }).limit(12).lean(),
    Promise.all([
      Category.countDocuments({ active: true }),
      Skill.countDocuments({ active: true }),
    ]),
  ]);

  return res.json({
    categories,
    skills,
    stats: {
      categories: stats[0],
      skills: stats[1],
    },
  });
});

export default router;
