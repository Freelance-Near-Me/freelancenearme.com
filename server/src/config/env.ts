import dotenv from "dotenv";

dotenv.config();

function required(name: string): string {
  const value = process.env[name];
  if (!value) {
    throw new Error(`Missing required environment variable: ${name}`);
  }
  return value;
}

export const env = {
  port: Number(process.env.PORT ?? 5001),
  mongoUri: process.env.MONGODB_URI ?? "mongodb://127.0.0.1:27017/freelancenearme",
  jwtSecret: process.env.JWT_SECRET ?? "dev-only-change-in-production",
  clientUrl: process.env.CLIENT_URL ?? "http://localhost:5173",
  nodeEnv: process.env.NODE_ENV ?? "development",
  isProduction: process.env.NODE_ENV === "production",
};

export function assertProductionSecrets() {
  if (env.isProduction && env.jwtSecret === "dev-only-change-in-production") {
    throw new Error("Set JWT_SECRET in production");
  }
}
