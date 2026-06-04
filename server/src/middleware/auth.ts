import type { Request, Response, NextFunction } from "express";
import jwt from "jsonwebtoken";
import { env } from "../config/env.js";
import { User, type IUserDocument } from "../models/User.js";

export interface AuthPayload {
  userId: string;
  accountType: "employer" | "freelancer";
}

export interface AuthenticatedRequest extends Request {
  user?: IUserDocument;
  auth?: AuthPayload;
}

export function signToken(payload: AuthPayload): string {
  return jwt.sign(payload, env.jwtSecret, { expiresIn: "7d" });
}

export function setAuthCookie(res: Response, token: string) {
  res.cookie("token", token, {
    httpOnly: true,
    secure: env.isProduction,
    sameSite: env.isProduction ? "strict" : "lax",
    maxAge: 7 * 24 * 60 * 60 * 1000,
  });
}

export async function requireAuth(
  req: AuthenticatedRequest,
  res: Response,
  next: NextFunction
) {
  try {
    const header = req.headers.authorization;
    const bearer = header?.startsWith("Bearer ") ? header.slice(7) : undefined;
    const token = bearer ?? req.cookies?.token;

    if (!token) {
      return res.status(401).json({ error: "Authentication required" });
    }

    const decoded = jwt.verify(token, env.jwtSecret) as AuthPayload;
    const user = await User.findById(decoded.userId).select("-passwordHash");

    if (!user) {
      return res.status(401).json({ error: "User not found" });
    }

    req.auth = decoded;
    req.user = user;
    next();
  } catch {
    return res.status(401).json({ error: "Invalid or expired session" });
  }
}

export function requireEmployer(
  req: AuthenticatedRequest,
  res: Response,
  next: NextFunction
) {
  if (req.user?.accountType !== "employer") {
    return res.status(403).json({ error: "Employer account required" });
  }
  next();
}

export function toPublicUser(user: IUserDocument) {
  return {
    id: user._id.toString(),
    username: user.username,
    email: user.email,
    firstName: user.firstName,
    lastName: user.lastName,
    accountType: user.accountType,
    country: user.country,
    city: user.city,
    headline: user.headline,
    bio: user.bio,
    skills: user.skills,
    hourlyRate: user.hourlyRate,
    verified: user.verified,
    balance: user.balance,
    avatarUrl: user.avatarUrl,
    createdAt: user.createdAt,
  };
}
