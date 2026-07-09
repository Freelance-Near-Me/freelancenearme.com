import Link from "next/link";
import { listCategories } from "@/actions/categories";
import { routes } from "@/lib/routes";

export async function CategoryGrid() {
  const categories = (await listCategories()).filter((cat) => cat._count.jobs > 0);
  if (categories.length === 0) return null;

  return (
    <div>
      <p className="eyebrow mb-3">Browse by craft</p>
      <h2 className="font-serif text-3xl text-ink-900">Find talent and projects by category</h2>
      <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {categories.map((cat) => (
          <Link
            key={cat.id}
            href={routes.category(cat.slug)}
            className="card-featured block p-5"
          >
            <h3 className="font-semibold text-ink-900">{cat.name}</h3>
            {cat.description && (
              <p className="mt-1 line-clamp-2 text-sm text-ink-600">{cat.description}</p>
            )}
            <p className="mt-2 text-sm text-ink-500">
              {cat._count.jobs} {cat._count.jobs === 1 ? "job" : "jobs"}
              {cat.isLocal ? " · Local" : ""}
            </p>
          </Link>
        ))}
      </div>
    </div>
  );
}
