import { prisma, type ActivityType } from "@fnm/database";

export async function logContractActivity({
  contractId,
  actorId,
  type,
  title,
  body,
}: {
  contractId: string;
  actorId?: string | null;
  type: ActivityType;
  title: string;
  body?: string;
}) {
  await prisma.contractActivity.create({
    data: {
      contractId,
      actorId: actorId ?? undefined,
      type,
      title,
      body,
    },
  });
}
