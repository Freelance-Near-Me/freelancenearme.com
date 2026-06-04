import { useQuery } from "@tanstack/react-query";
import { useLocation } from "react-router-dom";
import { api } from "../lib/api";

export function ContentPage() {
  const { pathname } = useLocation();
  const apiSlug = pathname.replace(/^\//, "") || "about";

  const { data, isLoading, error } = useQuery({
    queryKey: ["page", apiSlug],
    queryFn: () =>
      api<{ page: { title: string; body: string } }>(`/api/catalog/pages/${apiSlug}`),
  });

  if (isLoading) return <p className="mx-auto max-w-3xl px-4 py-12 text-muted">Loading…</p>;
  if (error || !data?.page)
    return <p className="mx-auto max-w-3xl px-4 py-12 text-muted">Page not found.</p>;

  return (
    <article className="mx-auto max-w-3xl px-4 py-12">
      <h1 className="font-display text-4xl text-ink">{data.page.title}</h1>
      <div
        className="prose prose-slate mt-8 max-w-none"
        dangerouslySetInnerHTML={{ __html: data.page.body }}
      />
    </article>
  );
}
