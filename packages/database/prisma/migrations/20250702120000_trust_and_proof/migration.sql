-- CreateEnum
CREATE TYPE "VerificationTier" AS ENUM ('UNVERIFIED', 'EMAIL', 'VERIFIED', 'TOP_RATED');

-- AlterTable
ALTER TABLE "TalentProfile" ADD COLUMN "verificationTier" "VerificationTier" NOT NULL DEFAULT 'UNVERIFIED';
ALTER TABLE "TalentProfile" ADD COLUMN "jobSuccessScore" INTEGER;

-- CreateTable
CREATE TABLE "ProofClient" (
    "id" TEXT NOT NULL,
    "name" TEXT NOT NULL,
    "logoUrl" TEXT,
    "websiteUrl" TEXT,
    "permissionGranted" BOOLEAN NOT NULL DEFAULT false,
    "active" BOOLEAN NOT NULL DEFAULT true,
    "sortOrder" INTEGER NOT NULL DEFAULT 0,
    "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updatedAt" TIMESTAMP(3) NOT NULL,

    CONSTRAINT "ProofClient_pkey" PRIMARY KEY ("id")
);

-- CreateTable
CREATE TABLE "ProofTestimonial" (
    "id" TEXT NOT NULL,
    "quote" TEXT NOT NULL,
    "authorName" TEXT NOT NULL,
    "authorTitle" TEXT,
    "authorInitials" TEXT,
    "approved" BOOLEAN NOT NULL DEFAULT false,
    "featured" BOOLEAN NOT NULL DEFAULT false,
    "sortOrder" INTEGER NOT NULL DEFAULT 0,
    "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updatedAt" TIMESTAMP(3) NOT NULL,

    CONSTRAINT "ProofTestimonial_pkey" PRIMARY KEY ("id")
);

-- CreateIndex
CREATE INDEX "ProofClient_active_permissionGranted_idx" ON "ProofClient"("active", "permissionGranted");

-- CreateIndex
CREATE INDEX "ProofTestimonial_featured_approved_idx" ON "ProofTestimonial"("featured", "approved");

-- Backfill verified talents
UPDATE "TalentProfile" SET "verificationTier" = 'VERIFIED' WHERE "verified" = true;
