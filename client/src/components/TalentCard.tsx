import { Link } from "react-router-dom";
import type { User } from "../types";

export function TalentCard({ talent }: { talent: User }) {
  const talentId = talent.id ?? talent._id ?? "";
  const location = [talent.city, talent.country].filter(Boolean).join(", ");

  return (
    <article className="rounded-2xl border border-slate-200 bg-card p-5 shadow-sm transition hover:border-brand-200 hover:shadow-md">
      <div className="flex items-start gap-4">
        <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-100 text-lg font-semibold text-brand-700">
          {talent.firstName[0]}
          {talent.lastName[0]}
        </div>
        <div>
          <Link to={`/talents/${talentId}`} className="font-semibold text-ink hover:text-brand-600">
            {talent.firstName} {talent.lastName}
          </Link>
          <p className="text-sm text-muted">@{talent.username}</p>
          {talent.headline && <p className="mt-2 text-sm text-ink">{talent.headline}</p>}
        </div>
      </div>
      {talent.skills && talent.skills.length > 0 && (
        <div className="mt-4 flex flex-wrap gap-2">
          {talent.skills.slice(0, 5).map((s) => (
            <span
              key={s._id}
              className="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700"
            >
              {s.name}
            </span>
          ))}
        </div>
      )}
      <div className="mt-4 flex items-center justify-between text-sm">
        {talent.hourlyRate != null && (
          <span className="font-semibold">${talent.hourlyRate}/hr</span>
        )}
        {location && <span className="text-muted">{location}</span>}
      </div>
    </article>
  );
}
