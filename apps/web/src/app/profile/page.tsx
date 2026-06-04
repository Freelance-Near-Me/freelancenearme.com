import { redirect } from "next/navigation";
import { UserRole } from "@fnm/database";
import { getProfileForEdit, updateProfile } from "@/actions/profile";
import { listSkills } from "@/actions/skills";
import { requireUser } from "@/lib/auth";
import { SkillPicker } from "@/components/skill-picker";
import { Button } from "@/components/ui/button";

export default async function ProfilePage() {
  await requireUser();
  const profile = await getProfileForEdit();
  if (!profile) redirect("/onboarding");

  const skills = profile.role === UserRole.TALENT ? await listSkills() : [];
  const selectedSkillIds =
    profile.talentProfile?.skills.map((s) => s.skillId) ?? [];

  return (
    <div className="mx-auto max-w-lg px-4 py-12">
      <h1 className="font-serif text-3xl text-slate-900">Your profile</h1>
      <p className="mt-2 text-slate-600">@{profile.username}</p>

      <form action={updateProfile} className="mt-8 space-y-4">
        <div className="grid gap-4 sm:grid-cols-2">
          <Field label="First name" name="firstName" defaultValue={profile.firstName} required />
          <Field label="Last name" name="lastName" defaultValue={profile.lastName} required />
        </div>
        <Field label="Country" name="country" defaultValue={profile.country ?? ""} />
        <Field label="City" name="city" defaultValue={profile.city ?? ""} />

        {profile.role === UserRole.CLIENT && profile.clientProfile && (
          <>
            <Field label="Company" name="companyName" defaultValue={profile.clientProfile.companyName ?? ""} />
            <Field label="Company size" name="companySize" defaultValue={profile.clientProfile.companySize ?? ""} />
            <Field label="Website" name="website" defaultValue={profile.clientProfile.website ?? ""} />
            <label className="block text-sm">
              <span className="font-medium">Bio</span>
              <textarea
                name="bio"
                rows={4}
                defaultValue={profile.clientProfile.bio ?? ""}
                className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
              />
            </label>
          </>
        )}

        {profile.role === UserRole.TALENT && profile.talentProfile && (
          <>
            <Field label="Headline" name="headline" defaultValue={profile.talentProfile.headline ?? ""} />
            <label className="block text-sm">
              <span className="font-medium">Bio</span>
              <textarea
                name="bio"
                rows={4}
                defaultValue={profile.talentProfile.bio ?? ""}
                className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
              />
            </label>
            <Field
              label="Hourly rate ($)"
              name="hourlyRate"
              type="number"
              defaultValue={profile.talentProfile.hourlyRate?.toString() ?? ""}
            />
            <label className="block text-sm">
              <span className="font-medium">Availability</span>
              <select
                name="availability"
                defaultValue={profile.talentProfile.availability ?? "open"}
                className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
              >
                <option value="open">Open</option>
                <option value="limited">Limited</option>
                <option value="unavailable">Unavailable</option>
              </select>
            </label>
            <SkillPicker skills={skills} selectedIds={selectedSkillIds} />
          </>
        )}

        <Button type="submit" className="w-full">
          Save profile
        </Button>
      </form>

      {profile.role === UserRole.TALENT && (
        <p className="mt-4 text-center text-sm text-slate-500">
          <a href={`/freelancers/${profile.username}`} className="text-blue-600 hover:underline">
            View public profile
          </a>
        </p>
      )}
    </div>
  );
}

function Field({
  label,
  name,
  defaultValue,
  type = "text",
  required,
}: {
  label: string;
  name: string;
  defaultValue?: string;
  type?: string;
  required?: boolean;
}) {
  return (
    <label className="block text-sm">
      <span className="font-medium">{label}</span>
      <input
        name={name}
        type={type}
        defaultValue={defaultValue}
        required={required}
        className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
      />
    </label>
  );
}
