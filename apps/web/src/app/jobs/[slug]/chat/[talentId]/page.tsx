import Link from "next/link";
import { notFound, redirect } from "next/navigation";
import { getJobBySlug } from "@/actions/jobs";
import { getOrCreateThread } from "@/actions/messages";
import { getCurrentUser } from "@/lib/auth";
import { MessagePanel } from "@/components/message-panel";

export default async function JobChatPage({
  params,
}: {
  params: Promise<{ slug: string; talentId: string }>;
}) {
  const { slug, talentId } = await params;
  const user = await getCurrentUser();
  if (!user) redirect("/sign-in");

  const job = await getJobBySlug(slug);
  if (!job) notFound();

  const isParticipant = user.id === job.posterId || user.id === talentId;
  if (!isParticipant) notFound();

  const thread = await getOrCreateThread(job.id, talentId);
  const other =
    user.id === job.posterId
      ? job.proposals.find((p) => p.talentId === talentId)?.talent
      : job.poster;

  return (
    <div className="mx-auto max-w-2xl px-4 py-12">
      <Link href={`/jobs/${slug}`} className="text-sm text-blue-600">
        ← {job.title}
      </Link>
      <h1 className="mt-6 text-xl font-semibold text-slate-900">
        Messages
        {other && (
          <span className="font-normal text-slate-600">
            {" "}
            with {other.firstName} {other.lastName}
          </span>
        )}
      </h1>
      <div className="mt-6">
        <MessagePanel
          threadId={thread.id}
          messages={thread.messages}
          currentUserId={user.id}
        />
      </div>
    </div>
  );
}
