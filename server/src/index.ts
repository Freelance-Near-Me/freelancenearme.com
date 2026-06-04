import express from "express";
import cors from "cors";
import helmet from "helmet";
import morgan from "morgan";
import cookieParser from "cookie-parser";
import rateLimit from "express-rate-limit";
import mongoose from "mongoose";
import { assertProductionSecrets, env } from "./config/env.js";
import authRoutes from "./routes/auth.js";
import projectRoutes from "./routes/projects.js";
import talentRoutes from "./routes/talents.js";
import catalogRoutes from "./routes/catalog.js";

assertProductionSecrets();

const app = express();

app.use(
  cors({
    origin: env.clientUrl,
    credentials: true,
  })
);
app.use(helmet());
app.use(morgan(env.isProduction ? "combined" : "dev"));
app.use(express.json({ limit: "1mb" }));
app.use(cookieParser());
app.use(
  rateLimit({
    windowMs: 15 * 60 * 1000,
    max: 300,
    standardHeaders: true,
    legacyHeaders: false,
  })
);

app.get("/api/health", (_req, res) => {
  res.json({ ok: true, service: "freelancenearme-api" });
});

app.use("/api/auth", authRoutes);
app.use("/api/projects", projectRoutes);
app.use("/api/talents", talentRoutes);
app.use("/api/catalog", catalogRoutes);

app.use((_req, res) => {
  res.status(404).json({ error: "Not found" });
});

async function start() {
  await mongoose.connect(env.mongoUri);
  console.log("Connected to MongoDB");

  app.listen(env.port, () => {
    console.log(`API listening on http://localhost:${env.port}`);
  });
}

start().catch((err) => {
  console.error("Failed to start server:", err);
  process.exit(1);
});
