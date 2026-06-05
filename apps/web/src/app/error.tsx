"use client";

import { useEffect } from "react";
import Link from "next/link";

export default function Error({
  error,
  reset,
}: {
  error: Error & { digest?: string };
  reset: () => void;
}) {
  useEffect(() => {
    console.error(error);
  }, [error]);

  return (
    <div className="mx-auto max-w-lg px-4 py-20 text-center">
      <h1 className="font-serif text-2xl text-slate-900">Something went wrong</h1>
      <p className="mt-3 text-sm text-slate-600">
        This is usually a missing or invalid environment variable on the server (for example{" "}
        <code className="rounded bg-slate-100 px-1">DATABASE_URL</code> or Clerk keys).
      </p>
      <div className="mt-8 flex flex-wrap justify-center gap-3">
        <button
          type="button"
          onClick={() => reset()}
          className="rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
        >
          Try again
        </button>
        <Link
          href="/"
          className="rounded-full border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
        >
          Home
        </Link>
      </div>
      {error.digest && (
        <p className="mt-6 text-xs text-slate-400">Reference: {error.digest}</p>
      )}
    </div>
  );
}
