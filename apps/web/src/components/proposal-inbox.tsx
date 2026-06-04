import Link from "next/link";
import { ProposalStatus } from "@fnm/database";
import { shortlistProposal, declineProposal } from "@/actions/proposals";
import { sendOfferFromProposal } from "@/actions/contracts";
import { formatMoney } from "@/lib/utils";
import { Button } from "@/components/ui/button";

type ProposalRow = {
  id: string;
  status: ProposalStatus;
  coverLetter: string;
  bidAmount: { toString(): string };
  deliveryDays: number;
  talent: {
    id: string;
    firstName: string;
    lastName: string;
    username: string;
    talentProfile: { headline: string | null } | null;
  };
};

export function ProposalInbox({
  proposals,
  jobSlug,
}: {
  proposals: ProposalRow[];
  jobSlug: string;
}) {
  if (proposals.length === 0) {
    return <p className="text-slate-600">No proposals yet.</p>;
  }

  return (
    <ul className="space-y-4">
      {proposals.map((p) => (
        <li key={p.id} className="rounded-2xl border border-slate-200 bg-white p-5">
          <div className="flex flex-wrap items-start justify-between gap-4">
            <div>
              <p className="font-semibold text-slate-900">
                {p.talent.firstName} {p.talent.lastName}{" "}
                <span className="font-normal text-slate-500">@{p.talent.username}</span>
              </p>
              {p.talent.talentProfile?.headline && (
                <p className="text-sm text-slate-600">{p.talent.talentProfile.headline}</p>
              )}
              <p className="mt-2 text-sm text-slate-700 line-clamp-3">{p.coverLetter}</p>
            </div>
            <div className="text-right text-sm">
              <p className="font-semibold">{formatMoney(parseFloat(p.bidAmount.toString()))}</p>
              <p className="text-slate-500">{p.deliveryDays} days</p>
              <p className="mt-1 capitalize text-slate-500">{p.status.toLowerCase()}</p>
            </div>
          </div>
          <div className="mt-4 flex flex-wrap gap-2">
            <Link
              href={`/jobs/${jobSlug}/chat/${p.talent.id}`}
              className="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
            >
              Message
            </Link>
            {p.status === ProposalStatus.SUBMITTED && (
              <form action={shortlistProposal.bind(null, p.id)}>
                <Button type="submit" variant="secondary">
                  Shortlist
                </Button>
              </form>
            )}
            {p.status === ProposalStatus.SHORTLISTED && (
              <form action={sendOfferFromProposal.bind(null, p.id)}>
                <Button type="submit">Send offer</Button>
              </form>
            )}
            {p.status !== ProposalStatus.DECLINED && p.status !== ProposalStatus.ACCEPTED && (
              <form action={declineProposal.bind(null, p.id)}>
                <Button type="submit" variant="ghost">
                  Decline
                </Button>
              </form>
            )}
          </div>
        </li>
      ))}
    </ul>
  );
}
