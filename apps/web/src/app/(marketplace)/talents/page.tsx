import Link from "next/link";
import { prisma } from "@fnm/database";
import { formatMoney } from "@/lib/utils";

export default async function TalentsPage() {
  const talents = await prisma.user.findMany({
    where: { role: "TALENT", talentProfile: { verified: true } },
    include: {
      talentProfile: { include: { skills: { include: { skill: true } } } },
    },
    take: 24,
    orderBy: { createdAt: "desc" },
  });

  return (
    <div className="mx-auto max-w-6xl px-4 py-12">
      <h1 className="font-serif text-4xl text-slate-900">Find talent</h1>
      <p className="mt-2 text-slate-600">Verified freelancers on the platform</p>
      <div className="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        {talents.map((t) => (
          <article
            key={t.id}
            className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
          >
            <Link href={`/freelancers/${t.username}`} className="font-semibold text-slate-900 hover:text-blue-600">
              {t.firstName} {t.lastName}
            </Link>
            <p className="text-sm text-slate-500">@{t.username}</p>
            {t.talentProfile?.headline && (
              <p className="mt-2 text-sm text-slate-700">{t.talentProfile.headline}</p>
            )}
            {t.talentProfile?.hourlyRate != null && (
              <p className="mt-3 text-sm font-semibold">
                {formatMoney(Number(t.talentProfile.hourlyRate))}/hr
              </p>
            )}
            <div className="mt-3 flex flex-wrap gap-1">
              {t.talentProfile?.skills.slice(0, 4).map((ts) => (
                <span
                  key={ts.skillId}
                  className="rounded bg-slate-100 px-2 py-0.5 text-xs text-slate-700"
                >
                  {ts.skill.name}
                </span>
              ))}
            </div>
          </article>
        ))}
      </div>
      {talents.length === 0 && (
        <p className="mt-8 text-slate-600">
          No talent profiles yet. Run <code className="rounded bg-slate-100 px-1">npm run db:seed</code>.
        </p>
      )}
    </div>
  );
}
