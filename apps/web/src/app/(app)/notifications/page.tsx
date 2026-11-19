import Link from "next/link";
import { redirect } from "next/navigation";
import {
  listNotifications,
  markAllNotificationsRead,
  markNotificationRead,
} from "@/actions/in-app-notifications";
import { PageShell } from "@/components/layout/page-shell";
import { Card, CardBody } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { EmptyState } from "@/components/ui/empty-state";
import { getCurrentUser } from "@/lib/auth";
import { formatDateTime } from "@/lib/format";
import { routes } from "@/lib/routes";

export default async function NotificationsPage() {
  const user = await getCurrentUser();
  if (!user) redirect(routes.signIn);

  const notifications = await listNotifications();
  const unread = notifications.filter((n) => !n.read).length;

  return (
    <PageShell
      title="Notifications"
      description={unread > 0 ? `${unread} unread` : "You're all caught up"}
      back={{ href: routes.dashboard, label: "Dashboard" }}
      width="lg"
      actions={
        unread > 0 ? (
          <form action={markAllNotificationsRead}>
            <Button type="submit" variant="secondary">
              Mark all read
            </Button>
          </form>
        ) : undefined
      }
    >
      {notifications.length === 0 ? (
        <EmptyState title="No notifications yet" description="Updates on proposals, contracts, and payments appear here." />
      ) : (
        <ul className="space-y-3">
          {notifications.map((n) => (
            <li key={n.id}>
              <Card className={n.read ? undefined : "border-ochre-500/35 bg-ochre-100/40"}>
                <CardBody>
                  <div className="flex flex-wrap items-start justify-between gap-2">
                    <div>
                      <p className="font-medium text-ink-900">{n.title}</p>
                      <p className="mt-1 text-sm text-ink-500">{n.body}</p>
                      <p className="mt-2 text-xs text-ink-500">{formatDateTime(n.createdAt)}</p>
                    </div>
                    {!n.read && (
                      <form action={markNotificationRead.bind(null, n.id)}>
                        <Button type="submit" variant="ghost" size="sm">
                          Mark read
                        </Button>
                      </form>
                    )}
                  </div>
                  {n.href ? (
                    <Link
                      href={n.href}
                      className="mt-3 inline-block text-sm font-medium text-ochre-700 hover:underline"
                    >
                      View details →
                    </Link>
                  ) : null}
                </CardBody>
              </Card>
            </li>
          ))}
        </ul>
      )}
    </PageShell>
  );
}
