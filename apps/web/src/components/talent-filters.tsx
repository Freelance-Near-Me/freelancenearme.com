import { listSkills } from "@/actions/skills";
import { Button, ButtonLink } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { NativeSelect } from "@/components/ui/native-select";
import { Separator } from "@/components/ui/separator";
import { routes } from "@/lib/routes";

type TalentFiltersProps = {
  searchParams: Record<string, string | undefined>;
};

export async function TalentFilters({ searchParams }: TalentFiltersProps) {
  const skills = await listSkills();
  const sp = searchParams;

  return (
    <Card className="bg-bone-50/80 shadow-soft">
      <CardContent className="space-y-5">
        <form method="get" className="space-y-5">
          <div className="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div className="flex-1 space-y-1.5">
              <Label htmlFor="talent-q">Search</Label>
              <Input
                id="talent-q"
                name="q"
                defaultValue={sp.q}
                placeholder="Search by name or headline…"
                className="bg-white"
              />
            </div>
            <Button type="submit" variant="ink">
              Search
            </Button>
          </div>

          <Separator />

          <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div className="space-y-1.5">
              <Label htmlFor="talent-skill">Skill</Label>
              <NativeSelect
                id="talent-skill"
                name="skill"
                defaultValue={sp.skill ?? ""}
                className="bg-white"
              >
                <option value="">Any skill</option>
                {skills.map((s) => (
                  <option key={s.id} value={s.slug}>
                    {s.name}
                  </option>
                ))}
              </NativeSelect>
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="talent-availability">Availability</Label>
              <NativeSelect
                id="talent-availability"
                name="availability"
                defaultValue={sp.availability ?? ""}
                className="bg-white"
              >
                <option value="">Any</option>
                <option value="open">Available</option>
                <option value="limited">Limited</option>
                <option value="unavailable">Unavailable</option>
              </NativeSelect>
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="minRate">Min rate ($/hr)</Label>
              <Input
                id="minRate"
                name="minRate"
                type="number"
                min={0}
                defaultValue={sp.minRate}
                className="bg-white"
              />
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="maxRate">Max rate ($/hr)</Label>
              <Input
                id="maxRate"
                name="maxRate"
                type="number"
                min={0}
                defaultValue={sp.maxRate}
                className="bg-white"
              />
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="talent-near">ZIP code or city</Label>
              <Input
                id="talent-near"
                name="nearPostcode"
                defaultValue={sp.nearPostcode}
                placeholder="e.g. 10001 or Austin"
                className="bg-white"
              />
            </div>

            <div className="space-y-1.5">
              <Label htmlFor="talent-radius">Radius</Label>
              <NativeSelect
                id="talent-radius"
                name="radiusMiles"
                defaultValue={sp.radiusMiles ?? ""}
                className="bg-white"
              >
                <option value="">Any distance</option>
                <option value="10">Within 10 miles</option>
                <option value="25">Within 25 miles</option>
                <option value="50">Within 50 miles</option>
              </NativeSelect>
            </div>
          </div>

          <ButtonLink href={routes.talents} variant="link" className="h-auto px-0">
            Clear filters
          </ButtonLink>
        </form>
      </CardContent>
    </Card>
  );
}
