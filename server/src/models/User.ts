import mongoose, { Schema, type Document, type Model } from "mongoose";

export type AccountType = "employer" | "freelancer";

export interface IUser {
  username: string;
  email: string;
  passwordHash: string;
  firstName: string;
  lastName: string;
  accountType: AccountType;
  country?: string;
  city?: string;
  headline?: string;
  bio?: string;
  skills: mongoose.Types.ObjectId[];
  hourlyRate?: number;
  verified: boolean;
  balance: number;
  avatarUrl?: string;
}

export interface IUserDocument extends IUser, Document {
  _id: mongoose.Types.ObjectId;
  createdAt: Date;
  updatedAt: Date;
}

const userSchema = new Schema<IUserDocument>(
  {
    username: { type: String, required: true, unique: true, trim: true, lowercase: true },
    email: { type: String, required: true, unique: true, trim: true, lowercase: true },
    passwordHash: { type: String, required: true },
    firstName: { type: String, required: true, trim: true },
    lastName: { type: String, required: true, trim: true },
    accountType: {
      type: String,
      enum: ["employer", "freelancer"],
      required: true,
    },
    country: { type: String, trim: true },
    city: { type: String, trim: true },
    headline: { type: String, trim: true, maxlength: 120 },
    bio: { type: String, trim: true, maxlength: 2000 },
    skills: [{ type: Schema.Types.ObjectId, ref: "Skill" }],
    hourlyRate: { type: Number, min: 0 },
    verified: { type: Boolean, default: false },
    balance: { type: Number, default: 0, min: 0 },
    avatarUrl: { type: String },
  },
  { timestamps: true }
);

userSchema.index({ accountType: 1, verified: 1 });
userSchema.index({ country: 1, city: 1 });

export const User: Model<IUserDocument> =
  mongoose.models.User ?? mongoose.model<IUserDocument>("User", userSchema);
