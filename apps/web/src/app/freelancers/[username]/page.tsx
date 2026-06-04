import Link from "next/link";
import { notFound } from "next/navigation";
import { getTalentByUsername } from "@/actions/profile";
import { formatMoney } from "@/lib/utils";

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

  return (
    <div className="mx-auto max-w-3xl px-4 py-12">
      <div className="flex items-start gap-6">
        <div className="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xl font-semibold text-blue-700">
          {talent.firstName[0]}
          {talent.lastName[0]}
        </div>
        <div>
          <h1 className="font-serif text-3xl text-slate-900">
            {talent.firstName} {talent.lastName}
          </h1>
          <p className="text-slate-500">@{talent.username}</p>
          {profile.headline && <p className="mt-3 text-lg text-slate-700">{profile.headline}</p>}
          {location && <p className="mt-2 text-sm text-slate-500">{location}</p>}
          {profile.hourlyRate != null && (
            <p className="mt-2 font-semibold text-slate-900">
              {formatMoney(Number(profile.hourlyRate))}/hr
            </p>
          )}
        </div>
      </div>

      {profile.bio && (
        <section className="mt-10">
          <h2 className="text-lg font-semibold">About</h2>
          <p className="mt-2 whitespace-pre-wrap text-slate-700">{profile.bio}</p>
        </section>
      )}

      {profile.skills.length > 0 && (
        <section className="mt-8">
          <h2 className="text-lg font-semibold">Skills</h2>
          <div className="mt-3 flex flex-wrap gap-2">
            {profile.skills.map((ts) => (
              <span
                key={ts.skillId}
                className="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700"
              >
                {ts.skill.name}
              </span>
            ))}
          </div>
        </section>
      )}

      <div className="mt-10">
        <Link
          href="/jobs"
          className="rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700"
        >
          Browse jobs to work with {talent.firstName}
        </Link>
      </div>
    </div>
  );
}
