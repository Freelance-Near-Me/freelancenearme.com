import { useQuery } from "@tanstack/react-query";
import { Link } from "react-router-dom";
import { ProjectCard } from "../components/ProjectCard";
import { useAuth } from "../context/AuthContext";
import { api } from "../lib/api";
import type { Paginated, Project } from "../types";

export function HomePage() {
  const { user } = useAuth();

  const { data: home } = useQuery({
    queryKey: ["home"],
    queryFn: () =>
      api<{ categories: Array<{ name: string; slug: string }>; skills: Array<{ name: string }> }>(
        "/api/catalog/home"
      ),
  });

  const { data: projects } = useQuery({
    queryKey: ["projects", "featured"],
    queryFn: () => api<Paginated<Project>>("/api/projects?limit=4"),
  });

  return (
    <div>
      <section className="relative overflow-hidden bg-gradient-to-br from-brand-700 via-brand-600 to-slate-900 text-white">
        <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_50%)]" />
        <div className="relative mx-auto max-w-6xl px-4 py-20 md:py-28">
          <p className="text-sm font-medium uppercase tracking-widest text-brand-100">
            Local & remote talent
          </p>
          <h1 className="mt-4 max-w-2xl font-display text-4xl leading-tight md:text-5xl lg:text-6xl">
            Hire freelancers near you — or anywhere in the world
          </h1>
          <p className="mt-6 max-w-xl text-lg text-brand-100">
            Post projects, browse open jobs, and connect with verified professionals on a fast,
            modern marketplace.
          </p>
          <div className="mt-10 flex flex-wrap gap-4">
            {user?.accountType === "employer" ? (
              <Link
                to="/post-job"
                className="rounded-full bg-white px-6 py-3 text-sm font-semibold text-brand-700 shadow-lg hover:bg-brand-50"
              >
                Post a project
              </Link>
            ) : (
              <Link
                to="/signup?type=employer"
                className="rounded-full bg-white px-6 py-3 text-sm font-semibold text-brand-700 shadow-lg hover:bg-brand-50"
              >
                Hire a freelancer
              </Link>
            )}
            <Link
              to="/signup?type=freelancer"
              className="rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10"
            >
              Apply as freelancer
            </Link>
            <Link
              to="/jobs"
              className="rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10"
            >
              Browse jobs
            </Link>
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-16">
        <h2 className="font-display text-3xl text-ink">Popular categories</h2>
        <div className="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          {home?.categories.map((cat) => (
            <Link
              key={cat.slug}
              to={`/jobs?category=${cat.slug}`}
              className="rounded-xl border border-slate-200 bg-card p-4 text-center font-medium hover:border-brand-300 hover:shadow-sm"
            >
              {cat.name}
            </Link>
          ))}
        </div>
      </section>

      <section className="bg-white py-16">
        <div className="mx-auto max-w-6xl px-4">
          <div className="flex items-end justify-between gap-4">
            <h2 className="font-display text-3xl text-ink">Latest projects</h2>
            <Link to="/jobs" className="text-sm font-semibold text-brand-600 hover:text-brand-700">
              View all →
            </Link>
          </div>
          <div className="mt-8 grid gap-6 md:grid-cols-2">
            {projects?.items.map((p) => (
              <ProjectCard key={p._id} project={p} />
            ))}
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-16">
        <div className="rounded-3xl bg-brand-50 p-8 md:p-12">
          <h2 className="font-display text-3xl text-ink">Built for employers & freelancers</h2>
          <p className="mt-4 max-w-2xl text-muted">
            This MERN rewrite replaces the legacy PHP platform with TypeScript, MongoDB, and a
            responsive React UI — with room to migrate payments, messaging, and project rooms next.
          </p>
          <Link
            to="/how-it-works"
            className="mt-6 inline-block text-sm font-semibold text-brand-600 hover:text-brand-700"
          >
            See how it works →
          </Link>
        </div>
      </section>
    </div>
  );
}
