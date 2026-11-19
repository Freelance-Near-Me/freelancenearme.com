import { addPortfolioItem, deletePortfolioItem, listMyPortfolio } from "@/actions/portfolio";
import { Button } from "@/components/ui/button";
import { Card, CardBody } from "@/components/ui/card";
import { Field } from "@/components/ui/form-field";

export async function PortfolioPanel() {
  const items = await listMyPortfolio();

  return (
    <section className="mt-10 space-y-6 border-t border-bone-200 pt-10">
      <div>
        <h2 className="text-lg font-semibold text-ink-900">Portfolio</h2>
        <p className="mt-1 text-sm text-ink-500">Showcase past work on your public profile.</p>
      </div>

      {items.length > 0 ? (
        <ul className="space-y-3">
          {items.map((item) => (
            <li key={item.id}>
              <Card>
                <CardBody className="flex items-start justify-between gap-4">
                  <div>
                    <p className="font-medium text-ink-900">{item.title}</p>
                    {item.description ? (
                      <p className="mt-1 text-sm text-ink-500">{item.description}</p>
                    ) : null}
                    {item.projectUrl ? (
                      <a
                        href={item.projectUrl}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="mt-2 inline-block text-sm text-ochre-700 hover:underline"
                      >
                        View project →
                      </a>
                    ) : null}
                  </div>
                  <form action={deletePortfolioItem.bind(null, item.id)}>
                    <Button type="submit" variant="quiet" size="sm" className="shrink-0">
                      Remove
                    </Button>
                  </form>
                </CardBody>
              </Card>
            </li>
          ))}
        </ul>
      ) : null}

      <form
        action={addPortfolioItem}
        className="space-y-3 rounded-xl border border-dashed border-bone-200 bg-bone-50/50 p-4"
      >
        <p className="text-sm font-medium text-ink-900">Add portfolio item</p>
        <Field label="Title" name="title" required />
        <Field label="Description" name="description" as="textarea" />
        <Field label="Project URL" name="projectUrl" placeholder="https://…" />
        <Field label="Image URL (optional)" name="imageUrl" placeholder="https://…" />
        <Button type="submit" variant="secondary">
          Add item
        </Button>
      </form>
    </section>
  );
}
