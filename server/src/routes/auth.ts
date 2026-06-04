import { Router } from "express";
import bcrypt from "bcryptjs";
import { z } from "zod";
import { User } from "../models/User.js";
import {
  requireAuth,
  setAuthCookie,
  signToken,
  toPublicUser,
  type AuthenticatedRequest,
} from "../middleware/auth.js";

const router = Router();

const registerSchema = z.object({
  username: z
    .string()
    .min(4)
    .max(20)
    .regex(/^[a-zA-Z0-9._-]+$/),
  email: z.string().email(),
  password: z.string().min(6).max(72),
  firstName: z.string().min(1).max(50),
  lastName: z.string().min(1).max(50),
  accountType: z.enum(["employer", "freelancer"]),
  country: z.string().optional(),
  city: z.string().optional(),
});

const loginSchema = z.object({
  email: z.string().email(),
  password: z.string().min(1),
});

router.post("/register", async (req, res) => {
  const parsed = registerSchema.safeParse(req.body);
  if (!parsed.success) {
    return res.status(400).json({ error: "Validation failed", details: parsed.error.flatten() });
  }

  const data = parsed.data;
  const exists = await User.findOne({
    $or: [{ email: data.email.toLowerCase() }, { username: data.username.toLowerCase() }],
  });

  if (exists) {
    return res.status(409).json({ error: "Email or username already in use" });
  }

  const passwordHash = await bcrypt.hash(data.password, 12);
  const user = await User.create({
    username: data.username.toLowerCase(),
    email: data.email.toLowerCase(),
    passwordHash,
    firstName: data.firstName,
    lastName: data.lastName,
    accountType: data.accountType,
    country: data.country,
    city: data.city,
    verified: data.accountType === "freelancer",
  });

  const token = signToken({
    userId: user._id.toString(),
    accountType: user.accountType,
  });
  setAuthCookie(res, token);

  return res.status(201).json({ user: toPublicUser(user), token });
});

router.post("/login", async (req, res) => {
  const parsed = loginSchema.safeParse(req.body);
  if (!parsed.success) {
    return res.status(400).json({ error: "Invalid credentials payload" });
  }

  const user = await User.findOne({ email: parsed.data.email.toLowerCase() });
  if (!user) {
    return res.status(401).json({ error: "Invalid email or password" });
  }

  const valid = await bcrypt.compare(parsed.data.password, user.passwordHash);
  if (!valid) {
    return res.status(401).json({ error: "Invalid email or password" });
  }

  const token = signToken({
    userId: user._id.toString(),
    accountType: user.accountType,
  });
  setAuthCookie(res, token);

  return res.json({ user: toPublicUser(user), token });
});

router.post("/logout", (_req, res) => {
  res.clearCookie("token");
  return res.json({ ok: true });
});

router.get("/me", requireAuth, (req: AuthenticatedRequest, res) => {
  return res.json({ user: toPublicUser(req.user!) });
});

export default router;
