import { UserRole } from "@fnm/database";
import { createJob } from "@/actions/jobs";
import { listSkills } from "@/actions/skills";
import { requireRole } from "@/lib/auth";
import { JobForm } from "@/components/job-form";

export default async function PostJobPage() {
  await requireRole(UserRole.CLIENT);
  const skills = await listSkills();

  return (
    <div className="mx-auto max-w-2xl px-4 py-12">
      <h1 className="font-serif text-4xl text-slate-900">Post a job</h1>
      <p className="mt-2 text-slate-600">Describe your project for freelancers</p>
      <div className="mt-8">
        <JobForm skills={skills} action={createJob} />
      </div>
    </div>
  );
}
