"use client";

import { useState } from "react";
import { sendContactMessage } from "@/actions/contact";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";

export function ContactForm() {
  const [status, setStatus] = useState<"idle" | "ok" | "error">("idle");
  const [error, setError] = useState<string | null>(null);

  async function handleSubmit(formData: FormData) {
    setStatus("idle");
    setError(null);
    const result = await sendContactMessage(formData);
    if (result.ok) {
      setStatus("ok");
      return;
    }
    setStatus("error");
    setError(result.error);
  }

  if (status === "ok") {
    return (
      <p className="rounded-xl bg-green-50 px-4 py-3 text-sm text-green-800">
        Message sent. We reply within two business days.
      </p>
    );
  }

  return (
    <form action={handleSubmit} className="space-y-4">
      <label className="block text-sm">
        <span className="font-medium text-ink-900">Name</span>
        <Input name="name" required minLength={2} className="mt-1 bg-white" autoComplete="name" />
      </label>
      <label className="block text-sm">
        <span className="font-medium text-ink-900">Email</span>
        <Input name="email" type="email" required className="mt-1 bg-white" autoComplete="email" />
      </label>
      <label className="block text-sm">
        <span className="font-medium text-ink-900">Message</span>
        <textarea
          name="message"
          required
          minLength={10}
          rows={6}
          className="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm"
        />
      </label>
      {error ? <p className="text-sm text-red-600">{error}</p> : null}
      <Button type="submit">Send message</Button>
    </form>
  );
}
