"use client";

import { useState } from "react";
import { sendMessage } from "@/actions/messages";
import { Button } from "@/components/ui/button";

type Message = {
  id: string;
  body: string;
  createdAt: Date;
  sender: { firstName: string; lastName: string; username: string };
};

export function MessagePanel({
  threadId,
  messages,
  currentUserId,
}: {
  threadId: string;
  messages: Message[];
  currentUserId: string;
}) {
  const [error, setError] = useState<string | null>(null);

  async function handleSubmit(formData: FormData) {
    setError(null);
    try {
      await sendMessage(formData);
    } catch (e) {
      setError(e instanceof Error ? e.message : "Failed to send");
    }
  }

  return (
    <div className="rounded-2xl border border-slate-200 bg-white">
      <div className="max-h-80 space-y-3 overflow-y-auto p-4">
        {messages.length === 0 && (
          <p className="text-sm text-slate-500">No messages yet. Start the conversation.</p>
        )}
        {messages.map((m) => (
          <div
            key={m.id}
            className={`rounded-xl px-3 py-2 text-sm ${
              m.sender.username ? "" : ""
            } ${messages.length ? "bg-slate-50" : ""}`}
          >
            <p className="text-xs font-medium text-slate-500">
              {m.sender.firstName} {m.sender.lastName}
            </p>
            <p className="mt-1 text-slate-800">{m.body}</p>
          </div>
        ))}
      </div>
      <form action={handleSubmit} className="border-t border-slate-200 p-4">
        <input type="hidden" name="threadId" value={threadId} />
        <textarea
          name="body"
          required
          rows={3}
          placeholder="Write a message…"
          className="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm"
        />
        {error && <p className="mt-2 text-sm text-red-600">{error}</p>}
        <Button type="submit" className="mt-2">
          Send
        </Button>
      </form>
    </div>
  );
}
