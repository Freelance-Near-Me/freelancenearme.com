import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { getTalentByUsername } from "@/actions/profile";
import { getTalentRatingStats, getJobSuccessScoreForTalent } from "@/actions/reviews";
import { AvailabilityBadge } from "@/components/availability-badge";
import { ReviewsList } from "@/components/reviews-list";
import { StarRating } from "@/components/star-rating";
import { VerifiedHumanBadge } from "@/components/trust/verified-human-badge";
import { JobSuccessScore } from "@/components/trust/job-success-score";
import { ButtonLink } from "@/components/ui/button";
import { Money } from "@/components/money/money";
import { routes } from "@/lib/routes";

export const revalidate = 3600;

export async function generateMetadata({
  params,
}: {
  params: Promise<{ username: string }>;
}): Promise<Metadata> {
  const { username } = await params;
  const talent = await getTalentByUsername(username);
  if (!talent) return { title: "Freelancer not found" };
  const name = `${talent.firstName} ${talent.lastName}`;
  const description =
    talent.talentProfile?.headline ??
    talent.talentProfile?.bio?.slice(0, 160) ??
    `${name} on Freelance Near Me.`;
  return { title: name, description, openGraph: { title: name, description } };
}

export default async function FreelancerProfilePage({
  params,
}: {
  params: Promise<{ username: string }>;
}) {
  const { username } = await params;
  const talent = await getTalentByUsername(username);
  if (!talent?.talentProfile) notFound();

  const profile = talent.talentProfile;
  const location = [talent.city, talent.country].filter(Boolean).join(", ");
  const [ratingStats, jss] = await Promise.all([
    getTalentRatingStats(talent.id),
    getJobSuccessScoreForTalent(talent.id),
  ]);

  return (
    <div className="container-elite py-12">
      <div className="flex items-start gap-6">
        <div className="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-ochre-100 text-xl font-semibold text-ochre-700">
          {talent.firstName[0]}
          {talent.lastName[0]}
        </div>
        <div className="flex-1">
          <div className="flex flex-wrap items-center gap-2">
            <h1 className="font-serif text-3xl text-ink-900">
              {talent.firstName} {talent.lastName}
            </h1>
            <VerifiedHumanBadge tier={profile.verificationTier} />
            <AvailabilityBadge availability={profile.availability} />
          </div>
          <p className="text-ink-500">@{talent.username}</p>
          {profile.headline && <p className="mt-3 text-lg text-ink-700">{profile.headline}</p>}
          {location && <p className="mt-2 text-sm text-ink-500">{location}</p>}
          {profile.hourlyRate != null && (
            <p className="mt-2 font-semibold">
              <Money amount={Number(profile.hourlyRate)} size="md" />
              <span className="text-ink-500">/hr</span>
            </p>
          )}
          <div className="mt-4 flex flex-wrap items-start gap-6">
            {ratingStats.count > 0 && (
              <div className="flex items-center gap-2">
                <StarRating rating={ratingStats.average} size="md" />
                <span className="text-sm text-ink-600">
                  {ratingStats.average.toFixed(1)} · {ratingStats.count}{" "}
                  {ratingStats.count === 1 ? "review" : "reviews"}
                </span>
              </div>
            )}
            <JobSuccessScore
              score={jss.score}
              components={jss.components}
              size="md"
            />
          </div>
        </div>
      </div>

      {profile.bio && (
        <section className="mt-10">
          <h2 className="text-lg font-semibold text-ink-900">About</h2>
          <p className="mt-2 whitespace-pre-wrap text-ink-700">{profile.bio}</p>
        </section>
      )}

      {profile.skills.length > 0 && (
        <section className="mt-8">
          <h2 className="text-lg font-semibold text-ink-900">Skills</h2>
          <div className="mt-3 flex flex-wrap gap-2">
            {profile.skills.map((ts) => (
              <Link
                key={ts.skillId}
                href={routes.hire(ts.skill.slug)}
                className="rounded-full bg-bone-50 px-3 py-1 text-sm font-medium text-ink-700 hover:bg-ochre-100 hover:text-ochre-700"
              >
                {ts.skill.name}
              </Link>
            ))}
          </div>
        </section>
      )}

      {profile.portfolioItems.length > 0 && (
        <section className="mt-10">
          <h2 className="text-lg font-semibold text-ink-900">Portfolio</h2>
          <div className="mt-4 grid gap-4 sm:grid-cols-2">
            {profile.portfolioItems.map((item) => (
              <article key={item.id} className="rounded-xl border border-bone-200 p-4">
                <h3 className="font-medium text-ink-900">{item.title}</h3>
                {item.description && (
                  <p className="mt-2 text-sm text-ink-600">{item.description}</p>
                )}
                {item.projectUrl && (
                  <a
                    href={item.projectUrl}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="mt-3 inline-block text-sm font-medium text-ochre-700 hover:underline"
                  >
                    View project →
                  </a>
                )}
              </article>
            ))}
          </div>
        </section>
      )}

      <section className="mt-10">
        <h2 className="text-lg font-semibold text-ink-900">Reviews</h2>
        <div className="mt-4">
          <ReviewsList reviews={talent.reviewsReceived} />
        </div>
      </section>

      <div className="mt-10 flex flex-wrap gap-3">
        <ButtonLink href={routes.jobs} variant="ink">
          Browse jobs
        </ButtonLink>
        <ButtonLink href={routes.talents} variant="quiet">
          More talent
        </ButtonLink>
      </div>
    </div>
  );
}
