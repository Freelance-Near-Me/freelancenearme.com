import {
  ContractStatus,
  MilestoneStatus,
  prisma,
  VerificationTier,
} from "@fnm/database";

const MIN_COMPLETED_CONTRACTS_FOR_PUBLIC_SCORE = 3;

export type JobSuccessScoreComponents = {
  avgRating: number | null;
  completionRate: number | null;
  onTimeRate: number | null;
  refundRate: number | null;
  repeatClientRate: number | null;
  disputeFreeRate: number | null;
  reviewCount: number;
  completedMilestones: number;
  refundedMilestones: number;
  completedContracts: number;
};

export type JobSuccessScoreResult = {
  score: number | null;
  components: JobSuccessScoreComponents;
};

export async function computeJobSuccessScore(
  talentUserId: string
): Promise<JobSuccessScoreResult> {
  const contracts = await prisma.contract.findMany({
    where: { talentId: talentUserId },
    include: {
      milestones: true,
    },
  });

  let paidCount = 0;
  let paidOnTime = 0;
  let cancelledCount = 0;

  for (const contract of contracts) {
    for (const m of contract.milestones) {
      if (m.status === MilestoneStatus.PAID) {
        paidCount++;
        if (!m.dueDate || (m.paidAt && m.paidAt <= m.dueDate)) {
          paidOnTime++;
        }
      } else if (m.status === MilestoneStatus.CANCELLED) {
        cancelledCount++;
      }
    }
  }

  const userReviews = await prisma.review.findMany({
    where: { revieweeId: talentUserId },
  });
  const ratingTotal = userReviews.reduce((s, r) => s + r.rating, 0);
  const ratingAvg = userReviews.length > 0 ? ratingTotal / userReviews.length : 0;
  const ratingNormalized = ratingAvg / 5;

  const completedContracts = contracts.filter(
    (c) => c.status === ContractStatus.COMPLETED
  );
  const disputedContracts = contracts.filter(
    (c) => c.status === ContractStatus.DISPUTED
  );

  const clientCounts = new Map<string, number>();
  for (const c of completedContracts) {
    clientCounts.set(c.clientId, (clientCounts.get(c.clientId) ?? 0) + 1);
  }
  const uniqueClients = clientCounts.size;
  const repeatClients = Array.from(clientCounts.values()).filter((n) => n >= 2).length;
  const repeatClientRate = uniqueClients > 0 ? repeatClients / uniqueClients : 0;

  const completionRate =
    paidCount + cancelledCount > 0 ? paidCount / (paidCount + cancelledCount) : 0;
  const onTimeDeliveryRate = paidCount > 0 ? paidOnTime / paidCount : 0;

  const terminalContracts = completedContracts.length + disputedContracts.length;
  const disputeFreeRate =
    terminalContracts > 0 ? 1 - disputedContracts.length / terminalContracts : 1;

  const completedContractsCount = completedContracts.length;

  let score: number | null = null;
  if (completedContractsCount >= MIN_COMPLETED_CONTRACTS_FOR_PUBLIC_SCORE) {
    const blended =
      0.3 * completionRate +
      0.25 * onTimeDeliveryRate +
      0.2 * ratingNormalized +
      0.15 * disputeFreeRate +
      0.1 * repeatClientRate;
    score = Math.round(100 * blended);
  }

  return {
    score,
    components: {
      avgRating: userReviews.length > 0 ? ratingAvg : null,
      completionRate: paidCount + cancelledCount > 0 ? completionRate : null,
      onTimeRate: paidCount > 0 ? onTimeDeliveryRate : null,
      refundRate: paidCount + cancelledCount > 0 ? 1 - completionRate : null,
      repeatClientRate: uniqueClients > 0 ? repeatClientRate : null,
      disputeFreeRate: terminalContracts > 0 ? disputeFreeRate : null,
      reviewCount: userReviews.length,
      completedMilestones: paidCount,
      refundedMilestones: cancelledCount,
      completedContracts: completedContractsCount,
    },
  };
}

export async function recomputeAndStoreJobSuccessScore(
  talentUserId: string
): Promise<JobSuccessScoreResult> {
  const result = await computeJobSuccessScore(talentUserId);

  const profile = await prisma.talentProfile.findUnique({
    where: { userId: talentUserId },
  });
  if (!profile) return result;

  let verificationTier = profile.verificationTier;

  if (result.score !== null && result.score >= 90) {
    if (
      verificationTier === VerificationTier.VERIFIED ||
      verificationTier === VerificationTier.EMAIL
    ) {
      verificationTier = VerificationTier.TOP_RATED;
    }
  } else if (verificationTier === VerificationTier.TOP_RATED) {
    verificationTier = VerificationTier.VERIFIED;
  }

  await prisma.talentProfile.update({
    where: { userId: talentUserId },
    data: {
      jobSuccessScore: result.score,
      verificationTier,
    },
  });

  return result;
}

export async function getJobSuccessScore(talentUserId: string) {
  const profile = await prisma.talentProfile.findUnique({
    where: { userId: talentUserId },
    select: { jobSuccessScore: true },
  });

  if (profile?.jobSuccessScore != null) {
    const components = await computeJobSuccessScore(talentUserId);
    return { score: profile.jobSuccessScore, components: components.components };
  }

  return computeJobSuccessScore(talentUserId);
}
