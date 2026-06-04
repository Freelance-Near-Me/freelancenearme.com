import mongoose, { Schema, type Document, type Model } from "mongoose";

export interface ISiteContent {
  slug: string;
  title: string;
  body: string;
  metaDescription?: string;
}

export interface ISiteContentDocument extends ISiteContent, Document {}

const siteContentSchema = new Schema<ISiteContentDocument>(
  {
    slug: { type: String, required: true, unique: true, lowercase: true },
    title: { type: String, required: true },
    body: { type: String, required: true },
    metaDescription: { type: String },
  },
  { timestamps: true }
);

export const SiteContent: Model<ISiteContentDocument> =
  mongoose.models.SiteContent ??
  mongoose.model<ISiteContentDocument>("SiteContent", siteContentSchema);
