export type AccountType = "employer" | "freelancer";

export interface User {
  id?: string;
  _id?: string;
  username: string;
  email: string;
  firstName: string;
  lastName: string;
  accountType: AccountType;
  country?: string;
  city?: string;
  headline?: string;
  bio?: string;
  skills?: Array<{ _id: string; name: string; slug: string }>;
  hourlyRate?: number;
  verified: boolean;
  balance: number;
  avatarUrl?: string;
  createdAt?: string;
}

export interface Project {
  _id: string;
  title: string;
  description: string;
  budgetMin: number;
  budgetMax: number;
  projectType: "fixed" | "hourly";
  environment: "remote" | "onsite" | "hybrid";
  experienceLevel: string;
  featured: boolean;
  status: string;
  country?: string;
  city?: string;
  createdAt: string;
  employerId?: {
    firstName: string;
    lastName: string;
    country?: string;
    city?: string;
    username: string;
    verified?: boolean;
  };
  skills?: Array<{ _id: string; name: string; slug: string }>;
  categoryId?: { name: string; slug: string };
}

export interface Paginated<T> {
  items: T[];
  pagination: { page: number; limit: number; total: number; pages: number };
}
