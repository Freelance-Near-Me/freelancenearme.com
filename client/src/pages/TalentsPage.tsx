import { useQuery } from "@tanstack/react-query";
import { useSearchParams } from "react-router-dom";
import { TalentCard } from "../components/TalentCard";
import { api } from "../lib/api";
import type { Paginated, User } from "../types";

export function TalentsPage() {
  const [params, setParams] = useSearchParams();
  const q = params.get("q") ?? "";

  const queryString = params.toString();
  const { data, isLoading } = useQuery({
    queryKey: ["talents", queryString],
    queryFn: () => api<Paginated<User>>(`/api/talents?${queryString || "limit=12"}`),
  });

  return (
    <div className="mx-auto max-w-6xl px-4 py-12">
      <h1 className="font-display text-4xl text-ink">Find talent</h1>
      <p className="mt-2 text-muted">Discover verified freelancers</p>

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
          placeholder="Search by name, username, or skills…"
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
        <p className="mt-12 text-muted">Loading freelancers…</p>
      ) : (
        <div className="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {data?.items.map((t) => (
            <TalentCard key={t.id ?? t._id} talent={t} />
          ))}
        </div>
      )}
    </div>
  );
}
