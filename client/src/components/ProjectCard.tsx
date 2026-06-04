import { Link } from "react-router-dom";
import type { Project } from "../types";

function formatBudget(min: number, max: number, type: string) {
  const range = `$${min.toLocaleString()} – $${max.toLocaleString()}`;
  return type === "hourly" ? `${range} / hr` : range;
}

export function ProjectCard({ project }: { project: Project }) {
  const employer = project.employerId;
  const location = [project.city, project.country].filter(Boolean).join(", ");

  return (
    <article className="group rounded-2xl border border-slate-200 bg-card p-5 shadow-sm transition hover:border-brand-200 hover:shadow-md">
      {project.featured && (
        <span className="mb-3 inline-block rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">
          Featured
        </span>
      )}
      <Link to={`/jobs/${project._id}`} className="block">
        <h3 className="font-semibold text-lg text-ink group-hover:text-brand-600">
          {project.title}
        </h3>
      </Link>
      <p className="mt-2 line-clamp-2 text-sm text-muted">{project.description}</p>
      <div className="mt-4 flex flex-wrap gap-2">
        {project.skills?.slice(0, 4).map((s) => (
          <span
            key={s._id}
            className="rounded-md bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-700"
          >
            {s.name}
          </span>
        ))}
      </div>
      <div className="mt-4 flex flex-wrap items-center justify-between gap-2 text-sm">
        <span className="font-semibold text-ink">
          {formatBudget(project.budgetMin, project.budgetMax, project.projectType)}
        </span>
        <span className="capitalize text-muted">{project.environment}</span>
      </div>
      {employer && (
        <p className="mt-3 text-xs text-muted">
          Posted by {employer.firstName} {employer.lastName}
          {location ? ` · ${location}` : ""}
        </p>
      )}
    </article>
  );
}
