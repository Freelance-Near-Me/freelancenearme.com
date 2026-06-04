import { useQuery } from "@tanstack/react-query";
import { Link, useParams } from "react-router-dom";
import { api } from "../lib/api";
import type { Project } from "../types";

export function JobDetailPage() {
  const { id } = useParams<{ id: string }>();

  const { data, isLoading, error } = useQuery({
    queryKey: ["project", id],
    queryFn: () => api<{ project: Project }>(`/api/projects/${id}`),
    enabled: !!id,
  });

  const project = data?.project;

  if (isLoading) return <p className="mx-auto max-w-3xl px-4 py-12 text-muted">Loading…</p>;
  if (error || !project)
    return (
      <p className="mx-auto max-w-3xl px-4 py-12 text-red-600">
        Project not found. <Link to="/jobs">Back to jobs</Link>
      </p>
    );

  const employer = project.employerId;

  return (
    <article className="mx-auto max-w-3xl px-4 py-12">
      <Link to="/jobs" className="text-sm text-brand-600 hover:text-brand-700">
        ← All jobs
      </Link>
      <h1 className="mt-6 font-display text-4xl text-ink">{project.title}</h1>
      <div className="mt-4 flex flex-wrap gap-3 text-sm text-muted">
        <span className="font-semibold text-ink">
          ${project.budgetMin.toLocaleString()} – ${project.budgetMax.toLocaleString()}
          {project.projectType === "hourly" ? " / hr" : ""}
        </span>
        <span>·</span>
        <span className="capitalize">{project.environment}</span>
        <span>·</span>
        <span className="capitalize">{project.experienceLevel} level</span>
      </div>
      {project.skills && project.skills.length > 0 && (
        <div className="mt-6 flex flex-wrap gap-2">
          {project.skills.map((s) => (
            <span
              key={s._id}
              className="rounded-md bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700"
            >
              {s.name}
            </span>
          ))}
        </div>
      )}
      <div
        className="prose prose-slate mt-8 max-w-none"
        dangerouslySetInnerHTML={{ __html: project.description.replace(/\n/g, "<br/>") }}
      />
      {employer && (
        <div className="mt-10 rounded-2xl border border-slate-200 bg-card p-6">
          <h2 className="font-semibold text-ink">About the client</h2>
          <p className="mt-2 text-muted">
            {employer.firstName} {employer.lastName} (@{employer.username})
            {[employer.city, employer.country].filter(Boolean).length > 0 &&
              ` · ${[employer.city, employer.country].filter(Boolean).join(", ")}`}
          </p>
        </div>
      )}
    </article>
  );
}
