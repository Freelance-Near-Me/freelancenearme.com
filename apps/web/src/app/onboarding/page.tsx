import { redirect } from "next/navigation";
import { completeOnboarding } from "@/actions/onboarding";
import { getCurrentUser } from "@/lib/auth";
import { Button } from "@/components/ui/button";

export default async function OnboardingPage({
  searchParams,
}: {
  searchParams: Promise<{ role?: string }>;
}) {
  const { role: roleParam } = await searchParams;
  const user = await getCurrentUser();
  if (user && user.username && user.firstName !== "User") {
    redirect("/dashboard");
  }

  const defaultRole = roleParam === "client" ? "client" : "talent";

  return (
    <div className="mx-auto max-w-lg px-4 py-12">
      <h1 className="font-serif text-3xl text-slate-900">Complete your profile</h1>
      <p className="mt-2 text-slate-600">Tell us how you&apos;ll use Freelance Near Me</p>

      <form action={completeOnboarding} className="mt-8 space-y-4">
        <fieldset className="grid grid-cols-2 gap-2 rounded-xl bg-slate-100 p-1">
          <label className="cursor-pointer">
            <input type="radio" name="role" value="client" defaultChecked={defaultRole === "client"} className="peer sr-only" />
            <span className="block rounded-lg py-2 text-center text-sm font-semibold peer-checked:bg-white peer-checked:text-blue-700">
              Hire talent
            </span>
          </label>
          <label className="cursor-pointer">
            <input type="radio" name="role" value="talent" defaultChecked={defaultRole === "talent"} className="peer sr-only" />
            <span className="block rounded-lg py-2 text-center text-sm font-semibold peer-checked:bg-white peer-checked:text-blue-700">
              Find work
            </span>
          </label>
        </fieldset>
        <div className="grid gap-4 sm:grid-cols-2">
          <Field label="First name" name="firstName" required />
          <Field label="Last name" name="lastName" required />
        </div>
        <Field label="Username" name="username" required />
        <Field label="Country" name="country" />
        <Field label="City" name="city" />
        <Field label="Company (clients)" name="companyName" />
        <Field label="Headline (talent)" name="headline" />
        <Field label="Hourly rate $ (talent)" name="hourlyRate" type="number" />
        <Button type="submit" className="w-full">
          Continue
        </Button>
      </form>
    </div>
  );
}

function Field({
  label,
  name,
  type = "text",
  required,
}: {
  label: string;
  name: string;
  type?: string;
  required?: boolean;
}) {
  return (
    <label className="block text-sm">
      <span className="font-medium">{label}</span>
      <input
        name={name}
        type={type}
        required={required}
        className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
      />
    </label>
  );
}
