import { auth, currentUser } from "@clerk/nextjs/server";
import { prisma, UserRole, type User } from "@fnm/database";
import { redirect } from "next/navigation";
import { upsertUserFromClerk, type ClerkUserPayload } from "@/lib/clerk-sync";
import { isClerkConfigured, isDatabaseConfigured, isDevAuthBypass } from "@/lib/env";

export async function getCurrentUser(): Promise<User | null> {
  if (!isDatabaseConfigured()) return null;

  if (isDevAuthBypass()) {
    const clerkId =
      process.env.DEV_AUTH_USER === "talent" ? "seed_talent_1" : "seed_client_1";
    return prisma.user.findUnique({ where: { clerkId } });
  }

  if (!isClerkConfigured()) return null;

  const { userId } = await auth();
  if (!userId) return null;

  const existing = await prisma.user.findUnique({ where: { clerkId: userId } });
  if (existing) return existing;

  return syncUserFromClerk();
}

export async function requireUser() {
  const user = await getCurrentUser();
  if (!user) redirect("/sign-in");
  return user;
}

export async function requireRole(role: UserRole) {
  const user = await requireUser();
  if (user.role !== role) redirect("/dashboard");
  return user;
}

export async function syncUserFromClerk(): Promise<User | null> {
  if (!isClerkConfigured() || !isDatabaseConfigured()) return null;

  const clerkUser = await currentUser();
  if (!clerkUser) return null;

  const payload: ClerkUserPayload = {
    id: clerkUser.id,
    first_name: clerkUser.firstName,
    last_name: clerkUser.lastName,
    username: clerkUser.username,
    image_url: clerkUser.imageUrl,
    primary_email_address_id: clerkUser.primaryEmailAddressId,
    email_addresses: clerkUser.emailAddresses.map((e) => ({
      id: e.id,
      email_address: e.emailAddress,
    })),
    public_metadata: clerkUser.publicMetadata as Record<string, unknown>,
    unsafe_metadata: clerkUser.unsafeMetadata as Record<string, unknown>,
  };

  return upsertUserFromClerk(payload);
}
