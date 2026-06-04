import { Link, NavLink, Outlet } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const navLinkClass = ({ isActive }: { isActive: boolean }) =>
  `text-sm font-medium transition-colors ${
    isActive ? "text-brand-600" : "text-muted hover:text-ink"
  }`;

export function Layout() {
  const { user, logout, loading } = useAuth();

  return (
    <div className="min-h-screen flex flex-col">
      <header className="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
        <div className="mx-auto flex max-w-6xl items-center justify-between gap-6 px-4 py-4">
          <Link to="/" className="font-display text-2xl text-ink tracking-tight">
            Freelance Near Me
          </Link>
          <nav className="hidden items-center gap-6 md:flex">
            <NavLink to="/jobs" className={navLinkClass}>
              Find Jobs
            </NavLink>
            <NavLink to="/talents" className={navLinkClass}>
              Find Talent
            </NavLink>
            <NavLink to="/how-it-works" className={navLinkClass}>
              How It Works
            </NavLink>
          </nav>
          <div className="flex items-center gap-3">
            {!loading && user ? (
              <>
                <NavLink
                  to="/dashboard"
                  className="hidden text-sm font-medium text-muted hover:text-ink sm:inline"
                >
                  Dashboard
                </NavLink>
                {user.accountType === "employer" && (
                  <Link
                    to="/post-job"
                    className="rounded-full bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-700"
                  >
                    Post a Job
                  </Link>
                )}
                <button
                  type="button"
                  onClick={() => logout()}
                  className="text-sm text-muted hover:text-ink"
                >
                  Sign out
                </button>
              </>
            ) : (
              <>
                <Link to="/login" className="text-sm font-medium text-muted hover:text-ink">
                  Log in
                </Link>
                <Link
                  to="/signup?type=employer"
                  className="rounded-full bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-700"
                >
                  Get started
                </Link>
              </>
            )}
          </div>
        </div>
      </header>

      <main className="flex-1">
        <Outlet />
      </main>

      <footer className="border-t border-slate-200 bg-white">
        <div className="mx-auto grid max-w-6xl gap-8 px-4 py-12 md:grid-cols-3">
          <div>
            <p className="font-display text-xl">Freelance Near Me</p>
            <p className="mt-2 text-sm text-muted">
              Connect with skilled freelancers near you — or anywhere.
            </p>
          </div>
          <div className="flex flex-col gap-2 text-sm">
            <Link to="/about" className="text-muted hover:text-ink">
              About
            </Link>
            <Link to="/how-it-works" className="text-muted hover:text-ink">
              How it works
            </Link>
            <Link to="/jobs" className="text-muted hover:text-ink">
              Browse jobs
            </Link>
          </div>
          <div className="flex flex-col gap-2 text-sm">
            <Link to="/terms" className="text-muted hover:text-ink">
              Terms
            </Link>
            <Link to="/privacy" className="text-muted hover:text-ink">
              Privacy
            </Link>
          </div>
        </div>
        <p className="border-t border-slate-100 py-4 text-center text-xs text-muted">
          © {new Date().getFullYear()} Freelance Near Me
        </p>
      </footer>
    </div>
  );
}
