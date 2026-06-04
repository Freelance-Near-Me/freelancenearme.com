import mongoose, { Schema, type Document, type Model } from "mongoose";

export type ProjectType = "fixed" | "hourly";
export type ProjectEnvironment = "remote" | "onsite" | "hybrid";
export type ProjectStatus = "open" | "in_progress" | "completed" | "cancelled";

export interface IProject {
  employerId: mongoose.Types.ObjectId;
  title: string;
  description: string;
  budgetMin: number;
  budgetMax: number;
  projectType: ProjectType;
  environment: ProjectEnvironment;
  experienceLevel: "entry" | "intermediate" | "expert";
  categoryId?: mongoose.Types.ObjectId;
  skills: mongoose.Types.ObjectId[];
  featured: boolean;
  visibility: "public" | "private";
  status: ProjectStatus;
  country?: string;
  city?: string;
}

export interface IProjectDocument extends IProject, Document {}

const projectSchema = new Schema<IProjectDocument>(
  {
    employerId: { type: Schema.Types.ObjectId, ref: "User", required: true, index: true },
    title: { type: String, required: true, trim: true, maxlength: 200 },
    description: { type: String, required: true, maxlength: 10000 },
    budgetMin: { type: Number, required: true, min: 0 },
    budgetMax: { type: Number, required: true, min: 0 },
    projectType: { type: String, enum: ["fixed", "hourly"], default: "fixed" },
    environment: { type: String, enum: ["remote", "onsite", "hybrid"], default: "remote" },
    experienceLevel: {
      type: String,
      enum: ["entry", "intermediate", "expert"],
      default: "intermediate",
    },
    categoryId: { type: Schema.Types.ObjectId, ref: "Category" },
    skills: [{ type: Schema.Types.ObjectId, ref: "Skill" }],
    featured: { type: Boolean, default: false },
    visibility: { type: String, enum: ["public", "private"], default: "public" },
    status: {
      type: String,
      enum: ["open", "in_progress", "completed", "cancelled"],
      default: "open",
      index: true,
    },
    country: { type: String },
    city: { type: String },
  },
  { timestamps: true }
);

projectSchema.index({ title: "text", description: "text" });
projectSchema.index({ featured: 1, createdAt: -1 });

export const Project: Model<IProjectDocument> =
  mongoose.models.Project ?? mongoose.model<IProjectDocument>("Project", projectSchema);
