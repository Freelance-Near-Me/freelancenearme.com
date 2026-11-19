import { InboxIcon } from "lucide-react";
import { ButtonLink } from "@/components/ui/button";
import {
  Empty,
  EmptyContent,
  EmptyDescription,
  EmptyHeader,
  EmptyMedia,
  EmptyTitle,
} from "@/components/ui/empty";

export function EmptyState({
  title,
  description,
  action,
}: {
  title: string;
  description?: string;
  action?: { label: string; href: string };
}) {
  return (
    <Empty className="border border-dashed border-bone-200 bg-bone-50/60">
      <EmptyHeader>
        <EmptyMedia variant="icon">
          <InboxIcon />
        </EmptyMedia>
        <EmptyTitle className="font-serif text-base text-ink-900">{title}</EmptyTitle>
        {description ? (
          <EmptyDescription className="text-ink-500">{description}</EmptyDescription>
        ) : null}
      </EmptyHeader>
      {action ? (
        <EmptyContent>
          <ButtonLink href={action.href}>{action.label}</ButtonLink>
        </EmptyContent>
      ) : null}
    </Empty>
  );
}
