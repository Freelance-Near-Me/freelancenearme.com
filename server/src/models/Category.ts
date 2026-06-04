import mongoose, { Schema, type Document, type Model } from "mongoose";

export interface ICategory {
  name: string;
  slug: string;
  parentId?: mongoose.Types.ObjectId | null;
  active: boolean;
}

export interface ICategoryDocument extends ICategory, Document {}

const categorySchema = new Schema<ICategoryDocument>(
  {
    name: { type: String, required: true, trim: true },
    slug: { type: String, required: true, unique: true, lowercase: true },
    parentId: { type: Schema.Types.ObjectId, ref: "Category", default: null },
    active: { type: Boolean, default: true },
  },
  { timestamps: true }
);

export const Category: Model<ICategoryDocument> =
  mongoose.models.Category ?? mongoose.model<ICategoryDocument>("Category", categorySchema);
