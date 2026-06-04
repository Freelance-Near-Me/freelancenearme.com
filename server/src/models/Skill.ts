import mongoose, { Schema, type Document, type Model } from "mongoose";

export interface ISkill {
  name: string;
  slug: string;
  parentId?: mongoose.Types.ObjectId | null;
  categoryId?: mongoose.Types.ObjectId;
  active: boolean;
}

export interface ISkillDocument extends ISkill, Document {}

const skillSchema = new Schema<ISkillDocument>(
  {
    name: { type: String, required: true, trim: true },
    slug: { type: String, required: true, unique: true, lowercase: true },
    parentId: { type: Schema.Types.ObjectId, ref: "Skill", default: null },
    categoryId: { type: Schema.Types.ObjectId, ref: "Category" },
    active: { type: Boolean, default: true },
  },
  { timestamps: true }
);

export const Skill: Model<ISkillDocument> =
  mongoose.models.Skill ?? mongoose.model<ISkillDocument>("Skill", skillSchema);
