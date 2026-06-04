import Link from "next/link";
import { redirect } from "next/navigation";
import {
  listNotifications,
  markAllNotificationsRead,
  markNotificationRead,
} from "@/actions/in-app-notifications";
import { getCurrentUser } from "@/lib/auth";
import { Button } from "@/components/ui/button";

function formatWhen(date: Date) {
  return new Intl.DateTimeFormat("en-US", {
    month: "short",
    day: "numeric",
    hour: "numeric",
    minute: "2-digit",
  }).format(date);
}

export default async function NotificationsPage() {
  const user = await getCurrentUser();
  if (!user) redirect("/sign-in");

  const notifications = await listNotifications();
  const unread = notifications.filter((n) => !n.read).length;

  return (
    <div className="mx-auto max-w-2xl px-4 py-12">
      <div className="flex flex-wrap items-center justify-between gap-4">
        <div>
          <h1 className="font-serif text-3xl text-slate-900">Notifications</h1>
          {unread > 0 && (
            <p className="mt-1 text-sm text-slate-600">{unread} unread</p>
          )}
        </div>
        {unread > 0 && (
          <form action={markAllNotificationsRead}>
            <Button type="submit" variant="secondary">
              Mark all read
            </Button>
          </form>
        )}
      </div>

      <ul className="mt-8 space-y-3">
        {notifications.map((n) => (
          <li
            key={n.id}
            className={`rounded-2xl border p-4 ${n.read ? "border-slate-200 bg-white" : "border-blue-200 bg-blue-50/50"}`}
          >
            <div className="flex flex-wrap items-start justify-between gap-2">
              <div>
                <p className="font-medium text-slate-900">{n.title}</p>
                <p className="mt-1 text-sm text-slate-600">{n.body}</p>
                <p className="mt-2 text-xs text-slate-500">{formatWhen(n.createdAt)}</p>
              </div>
              {!n.read && (
                <form action={markNotificationRead.bind(null, n.id)}>
                  <Button type="submit" variant="secondary" className="text-xs">
                    Mark read
                  </Button>
                </form>
              )}
            </div>
            {n.href && (
              <Link href={n.href} className="mt-3 inline-block text-sm font-medium text-blue-600">
                View →
              </Link>
            )}
          </li>
        ))}
        {notifications.length === 0 && (
          <p className="text-sm text-slate-500">You&apos;re all caught up.</p>
        )}
      </ul>
    </div>
  );
}
