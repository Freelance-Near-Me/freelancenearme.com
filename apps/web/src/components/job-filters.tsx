import { listCategories } from "@/actions/categories";
import { listSkills } from "@/actions/skills";
import { Button, ButtonLink } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { NativeSelect } from "@/components/ui/native-select";
import { Separator } from "@/components/ui/separator";
import { routes } from "@/lib/routes";

type JobFiltersProps = {
  searchParams: Record<string, string | undefined>;
};

export async function JobFilters({ searchParams }: JobFiltersProps) {
  const [categories, skills] = await Promise.all([listCategories(), listSkills()]);
  const sp = searchParams;

  return (
    <Card className="bg-bone-50/80 shadow-soft">
      <CardContent className="space-y-5">
        <form method="get" className="space-y-5">
          <div className="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div className="flex-1 space-y-1.5">
              <Label htmlFor="job-q">Search</Label>
              <Input
                id="job-q"
                name="q"
                defaultValue={sp.q}
                placeholder="Search jobs…"
                className="bg-white"
              />
            </div>
            <Button type="submit" variant="ink">
              Search
            </Button>
          </div>

          <Separator />

          <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <FilterSelect name="category" label="Category" defaultValue={sp.category}>
              <option value="">All categories</option>
              {categories.map((c) => (
                <option key={c.id} value={c.slug}>
                  {c.name}
                </option>
              ))}
            </FilterSelect>

            <FilterSelect name="skill" label="Skill" defaultValue={sp.skill}>
              <option value="">Any skill</option>
              {skills.map((s) => (
                <option key={s.id} value={s.slug}>
                  {s.name}
                </option>
              ))}
            </FilterSelect>

            <FilterSelect name="environment" label="Work style" defaultValue={sp.environment}>
              <option value="">Any</option>
              <option value="REMOTE">Remote</option>
              <option value="ONSITE">On-site</option>
              <option value="HYBRID">Hybrid</option>
            </FilterSelect>

            <FilterSelect name="billingMode" label="Budget type" defaultValue={sp.billingMode}>
              <option value="">Any</option>
              <option value="FIXED">Fixed price</option>
              <option value="HOURLY">Hourly</option>
            </FilterSelect>

            <FilterSelect
              name="experienceLevel"
              label="Experience"
              defaultValue={sp.experienceLevel}
            >
              <option value="">Any</option>
              <option value="ENTRY">Entry</option>
              <option value="INTERMEDIATE">Intermediate</option>
              <option value="EXPERT">Expert</option>
            </FilterSelect>

            <div className="space-y-1.5">
              <Label htmlFor="minBudget">Min budget ($)</Label>
              <Input
                id="minBudget"
                name="minBudget"
                type="number"
                min={0}
                defaultValue={sp.minBudget}
                className="bg-white"
              />
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="maxBudget">Max budget ($)</Label>
              <Input
                id="maxBudget"
                name="maxBudget"
                type="number"
                min={0}
                defaultValue={sp.maxBudget}
                className="bg-white"
              />
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="nearPostcode">ZIP code or city</Label>
              <Input
                id="nearPostcode"
                name="nearPostcode"
                defaultValue={sp.nearPostcode}
                placeholder="e.g. 10001 or Austin"
                className="bg-white"
              />
            </div>

            <FilterSelect name="radiusMiles" label="Radius" defaultValue={sp.radiusMiles}>
              <option value="">Any distance</option>
              <option value="10">Within 10 miles</option>
              <option value="25">Within 25 miles</option>
              <option value="50">Within 50 miles</option>
            </FilterSelect>
          </div>

          <div className="flex flex-wrap items-center gap-5 text-sm">
            <label className="flex items-center gap-2 text-ink-700">
              <input
                type="checkbox"
                name="featured"
                value="1"
                defaultChecked={sp.featured === "1"}
                className="size-4 rounded border-input accent-ochre-500"
              />
              Featured only
            </label>
            <label className="flex items-center gap-2 text-ink-700">
              <input
                type="checkbox"
                name="urgent"
                value="1"
                defaultChecked={sp.urgent === "1"}
                className="size-4 rounded border-input accent-ochre-500"
              />
              Urgent only
            </label>
            <ButtonLink href={routes.jobs} variant="link" className="ml-auto h-auto px-0">
              Clear filters
            </ButtonLink>
          </div>
        </form>
      </CardContent>
    </Card>
  );
}

function FilterSelect({
  name,
  label,
  defaultValue,
  children,
}: {
  name: string;
  label: string;
  defaultValue?: string;
  children: React.ReactNode;
}) {
  const id = `filter-${name}`;
  return (
    <div className="space-y-1.5">
      <Label htmlFor={id}>{label}</Label>
      <NativeSelect id={id} name={name} defaultValue={defaultValue ?? ""} className="bg-white">
        {children}
      </NativeSelect>
    </div>
  );
}
