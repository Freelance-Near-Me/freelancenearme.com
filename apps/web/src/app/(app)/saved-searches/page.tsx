import Link from "next/link";
import { deleteSavedSearch, getMySavedSearches } from "@/actions/saved-searches";
import { PageShell } from "@/components/layout/page-shell";
import { AppNav } from "@/components/layout/app-nav";
import { Card, CardBody } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { EmptyState } from "@/components/ui/empty-state";
import { routes } from "@/lib/routes";

function buildJobsUrl(filters: unknown) {
  if (!filters || typeof filters !== "object") return routes.jobs;
  const params = new URLSearchParams();
  for (const [key, value] of Object.entries(filters as Record<string, unknown>)) {
    if (value != null && value !== "") params.set(key, String(value));
  }
  const qs = params.toString();
  return qs ? `${routes.jobs}?${qs}` : routes.jobs;
}

export default async function SavedSearchesPage() {
  const searches = await getMySavedSearches();

  return (
    <PageShell title="Saved searches" description="Your saved job search filters" width="md">
      <AppNav />
      {searches.length === 0 ? (
        <EmptyState
          title="No saved searches"
          description="Save a search from the jobs page to get back to it quickly."
          action={{ label: "Browse jobs", href: routes.jobs }}
        />
      ) : (
        <ul className="space-y-3">
          {searches.map((search) => (
            <li key={search.id}>
              <Card>
                <CardBody className="flex flex-wrap items-center justify-between gap-4">
                  <div>
                    <p className="font-medium text-ink-900">{search.label}</p>
                    <p className="mt-1 text-xs text-ink-500">
                      Saved {search.createdAt.toLocaleDateString()}
                    </p>
                  </div>
                  <div className="flex gap-2">
                    <Link href={buildJobsUrl(search.filters)}>
                      <Button variant="quiet" type="button">
                        Run search
                      </Button>
                    </Link>
                    <form action={deleteSavedSearch.bind(null, search.id)}>
                      <Button variant="ghost" type="submit">
                        Delete
                      </Button>
                    </form>
                  </div>
                </CardBody>
              </Card>
            </li>
          ))}
        </ul>
      )}
    </PageShell>
  );
}
