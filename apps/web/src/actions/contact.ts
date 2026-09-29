"use server";

import { z } from "zod";
import { emailLayout, sendEmail } from "@/lib/email";
import { SUPPORT_EMAIL } from "@/lib/site";

const contactSchema = z.object({
  name: z.string().trim().min(2).max(120),
  email: z.string().trim().email().max(200),
  message: z.string().trim().min(10).max(5000),
});

function escapeHtml(value: string) {
  return value
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;");
}

export async function sendContactMessage(formData: FormData) {
  const parsed = contactSchema.safeParse({
    name: formData.get("name"),
    email: formData.get("email"),
    message: formData.get("message"),
  });
  if (!parsed.success) {
    return { ok: false as const, error: "Add your name, a valid email, and a message of at least a few words." };
  }

  if (!process.env.RESEND_API_KEY) {
    return {
      ok: false as const,
      error: `The form cannot send email yet. Write to ${SUPPORT_EMAIL} instead.`,
    };
  }

  const { name, email, message } = parsed.data;
  const subjectName = name.replace(/[\r\n]+/g, " ");
  await sendEmail({
    to: SUPPORT_EMAIL,
    subject: `Contact form: ${subjectName}`,
    html: emailLayout(
      "New contact form message",
      `<p><strong>${escapeHtml(name)}</strong> (${escapeHtml(email)})</p><p>${escapeHtml(message).replaceAll("\n", "<br />")}</p>`
    ),
  });

  return { ok: true as const };
}
