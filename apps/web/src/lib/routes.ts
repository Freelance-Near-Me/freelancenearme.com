/** Central route helpers — keep URLs consistent across the app. */

export const routes = {
  home: "/",
  jobs: "/jobs",
  job: (slug: string) => `/jobs/${slug}`,
  jobEdit: (slug: string) => `/jobs/${slug}/edit`,
  jobMessages: (slug: string, participantId: string) =>
    `/jobs/${slug}/messages/${participantId}`,
  postJob: "/jobs/post",
  talents: "/talents",
  categories: "/categories",
  category: (slug: string) => `/categories/${slug}`,
  hire: (skillSlug: string) => `/hire/${skillSlug}`,
  freelancer: (username: string) => `/freelancers/${username}`,
  dashboard: "/dashboard",
  profile: "/profile",
  notifications: "/notifications",
  contract: (id: string) => `/contracts/${id}`,
  payouts: "/settings/payouts",
  signIn: "/sign-in",
  signUp: (role?: "client" | "talent") =>
    role ? `/sign-up?role=${role}` : "/sign-up",
  onboarding: "/onboarding",
} as const;
