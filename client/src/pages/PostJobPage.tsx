import { FormEvent, useState } from "react";
import { Navigate, useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import { ApiError, api } from "../lib/api";

export function PostJobPage() {
  const { user, loading } = useAuth();
  const navigate = useNavigate();
  const [error, setError] = useState("");
  const [submitting, setSubmitting] = useState(false);

  if (!loading && !user) return <Navigate to="/login" replace />;
  if (!loading && user?.accountType !== "employer")
    return <Navigate to="/dashboard" replace />;

  async function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setError("");
    setSubmitting(true);
    const fd = new FormData(e.currentTarget);
    try {
      const { project } = await api<{ project: { _id: string } }>("/api/projects", {
        method: "POST",
        body: JSON.stringify({
          title: fd.get("title"),
          description: fd.get("description"),
          budgetMin: Number(fd.get("budgetMin")),
          budgetMax: Number(fd.get("budgetMax")),
          projectType: fd.get("projectType"),
          environment: fd.get("environment"),
          experienceLevel: fd.get("experienceLevel"),
        }),
      });
      navigate(`/jobs/${project._id}`);
    } catch (err) {
      setError(err instanceof ApiError ? err.message : "Failed to post job");
    } finally {
      setSubmitting(false);
    }
  }

  return (
    <div className="mx-auto max-w-2xl px-4 py-12">
      <h1 className="font-display text-4xl text-ink">Post a job</h1>
      <p className="mt-2 text-muted">Describe your project for freelancers</p>

      <form onSubmit={handleSubmit} className="mt-8 space-y-5">
        <label className="block text-sm">
          <span className="font-medium">Title</span>
          <input
            name="title"
            required
            minLength={5}
            className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
          />
        </label>
        <label className="block text-sm">
          <span className="font-medium">Description</span>
          <textarea
            name="description"
            required
            minLength={20}
            rows={8}
            className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
          />
        </label>
        <div className="grid gap-4 sm:grid-cols-2">
          <label className="block text-sm">
            <span className="font-medium">Min budget ($)</span>
            <input
              name="budgetMin"
              type="number"
              min={0}
              required
              className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
            />
          </label>
          <label className="block text-sm">
            <span className="font-medium">Max budget ($)</span>
            <input
              name="budgetMax"
              type="number"
              min={0}
              required
              className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5"
            />
          </label>
        </div>
        <div className="grid gap-4 sm:grid-cols-3">
          <Select label="Type" name="projectType" options={["fixed", "hourly"]} />
          <Select
            label="Environment"
            name="environment"
            options={["remote", "onsite", "hybrid"]}
          />
          <Select
            label="Experience"
            name="experienceLevel"
            options={["entry", "intermediate", "expert"]}
          />
        </div>
        {error && <p className="text-sm text-red-600">{error}</p>}
        <button
          type="submit"
          disabled={submitting}
          className="rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700 disabled:opacity-60"
        >
          {submitting ? "Publishing…" : "Publish job"}
        </button>
      </form>
    </div>
  );
}

function Select({
  label,
  name,
  options,
}: {
  label: string;
  name: string;
  options: string[];
}) {
  return (
    <label className="block text-sm capitalize">
      <span className="font-medium">{label}</span>
      <select name={name} className="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5">
        {options.map((o) => (
          <option key={o} value={o}>
            {o}
          </option>
        ))}
      </select>
    </label>
  );
}
