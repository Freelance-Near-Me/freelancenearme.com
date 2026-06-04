import { useQuery } from "@tanstack/react-query";
import { Link, Navigate } from "react-router-dom";
import { ProjectCard } from "../components/ProjectCard";
import { useAuth } from "../context/AuthContext";
import { api } from "../lib/api";
import type { Project } from "../types";

export function DashboardPage() {
  const { user, loading } = useAuth();

  const { data: myProjects } = useQuery({
    queryKey: ["my-projects"],
    queryFn: () => api<{ projects: Project[] }>("/api/projects/mine/list"),
    enabled: user?.accountType === "employer",
  });

  if (loading) return <p className="px-4 py-12 text-muted">Loading…</p>;
  if (!user) return <Navigate to="/login" replace />;

  return (
    <div className="mx-auto max-w-6xl px-4 py-12">
      <h1 className="font-display text-4xl text-ink">
        Hello, {user.firstName}
      </h1>
      <p className="mt-2 capitalize text-muted">{user.accountType} account</p>

      <div className="mt-8 grid gap-6 sm:grid-cols-3">
        <Stat label="Verified" value={user.verified ? "Yes" : "Pending"} />
        {user.accountType === "employer" && (
          <Stat label="Balance" value={`$${user.balance.toLocaleString()}`} />
        )}
        {user.accountType === "freelancer" && user.hourlyRate != null && (
          <Stat label="Hourly rate" value={`$${user.hourlyRate}/hr`} />
        )}
        <Stat label="Location" value={[user.city, user.country].filter(Boolean).join(", ") || "—"} />
      </div>

      {user.accountType === "employer" ? (
        <section className="mt-12">
          <div className="flex items-center justify-between">
            <h2 className="text-xl font-semibold">Your posted jobs</h2>
            <Link
              to="/post-job"
              className="text-sm font-semibold text-brand-600 hover:text-brand-700"
            >
              + Post new job
            </Link>
          </div>
          <div className="mt-6 grid gap-6 md:grid-cols-2">
            {myProjects?.projects.length ? (
              myProjects.projects.map((p) => <ProjectCard key={p._id} project={p} />)
            ) : (
              <p className="text-muted">No jobs yet. Post your first project.</p>
            )}
          </div>
        </section>
      ) : (
        <section className="mt-12 rounded-2xl border border-slate-200 bg-card p-8">
          <h2 className="text-xl font-semibold">Find your next project</h2>
          <p className="mt-2 text-muted">Browse open jobs matching your skills.</p>
          <Link
            to="/jobs"
            className="mt-4 inline-block rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-700"
          >
            Browse jobs
          </Link>
        </section>
      )}
    </div>
  );
}

function Stat({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-2xl border border-slate-200 bg-card p-5">
      <p className="text-xs font-medium uppercase tracking-wide text-muted">{label}</p>
      <p className="mt-2 text-lg font-semibold text-ink">{value}</p>
    </div>
  );
}
