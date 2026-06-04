import { useQuery } from "@tanstack/react-query";
import { useSearchParams } from "react-router-dom";
import { ProjectCard } from "../components/ProjectCard";
import { api } from "../lib/api";
import type { Paginated, Project } from "../types";

export function JobsPage() {
  const [params, setParams] = useSearchParams();
  const q = params.get("q") ?? "";

  const queryString = params.toString();
  const { data, isLoading } = useQuery({
    queryKey: ["projects", queryString],
    queryFn: () => api<Paginated<Project>>(`/api/projects?${queryString || "limit=12"}`),
  });

  return (
    <div className="mx-auto max-w-6xl px-4 py-12">
      <h1 className="font-display text-4xl text-ink">Find jobs</h1>
      <p className="mt-2 text-muted">Browse open freelance projects</p>

      <form
        className="mt-8 flex gap-3"
        onSubmit={(e) => {
          e.preventDefault();
          const form = new FormData(e.currentTarget);
          const term = String(form.get("q") ?? "");
          const next = new URLSearchParams(params);
          if (term) next.set("q", term);
          else next.delete("q");
          setParams(next);
        }}
      >
        <input
          name="q"
          defaultValue={q}
          placeholder="Search by title or description…"
          className="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
        />
        <button
          type="submit"
          className="rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700"
        >
          Search
        </button>
      </form>

      {isLoading ? (
        <p className="mt-12 text-muted">Loading projects…</p>
      ) : (
        <>
          <p className="mt-6 text-sm text-muted">
            {data?.pagination.total ?? 0} projects found
          </p>
          <div className="mt-8 grid gap-6 md:grid-cols-2">
            {data?.items.map((p) => (
              <ProjectCard key={p._id} project={p} />
            ))}
          </div>
        </>
      )}
    </div>
  );
}
