# Agent guide — Freelance Near Me

## Stack (authoritative)

- **App:** `apps/web` — Next.js 16, React 19, TypeScript, Tailwind CSS 4
- **DB:** `packages/database` — Prisma 7 + `@prisma/adapter-pg` + PostgreSQL (Neon)
- **Auth:** Clerk · **Payments:** Stripe Connect · **Email:** Resend · **Files:** Vercel Blob
- **Deploy:** Vercel (framework: Next.js)

## Do not extend

- `application/` — legacy PHP (CodeIgniter)
- `server/`, `client/` — archived MERN prototype

## Related repo (not this one)

**bmkrs bench** (partner portal, app.bmkrs.com) lives in a separate repo — do not add bench features here:

- https://github.com/shanepowel/bmkrs-bench
- local clone: `/Users/shanepowell/bmkrs-bench`

This repo (`master`) is **Freelance Near Me** only.

## Docs

- [docs/ENVIRONMENT.md](docs/ENVIRONMENT.md)
- [docs/DEPLOY_VERCEL.md](docs/DEPLOY_VERCEL.md)
- [docs/TECH_STACK.md](docs/TECH_STACK.md)
- [docs/PHP_MIGRATION.md](docs/PHP_MIGRATION.md)
- [TASKS.md](TASKS.md)
- [docs/PRODUCT_MODERNIZATION.md](docs/PRODUCT_MODERNIZATION.md)

## Commands

```bash
npm install && npm run dev          # http://localhost:3000
npm run build -w web
npm run db:push && npm run db:seed
```

## Cursor Cloud specific instructions

Environment is pre-provisioned (deps installed, Postgres installed, schema pushed + seeded). The startup update script only runs `npm install` (its `postinstall` runs `prisma generate`). Everything below is context for running/testing; it is not re-run automatically.

### Local Postgres (native, not Docker)
- Postgres 16 runs natively (the repo's `docker-compose.yml` is not used here). Role `fnm` / password `fnm_dev_password`, database `freelancenearme`, port 5432 — same credentials the compose file documents.
- If the DB is not reachable after a fresh boot, start the cluster: `sudo pg_ctlcluster 16 main start` (check with `pg_lsclusters`).

### DB URL gotcha (important, non-obvious)
- `packages/database/src/database-url.ts` treats `localhost` and `127.0.0.1` as *placeholder* hosts and ignores those URLs, so a `localhost` `DATABASE_URL` makes the app/Prisma think the DB is "not configured" (Prisma falls back to a `placeholder` URL and auth fails).
- Workaround used here: an `/etc/hosts` alias `127.0.0.1 fnm-postgres`, and both `apps/web/.env` and `packages/database/.env` use `postgresql://fnm:fnm_dev_password@fnm-postgres:5432/freelancenearme?schema=public`. If the alias is missing, re-add it: `echo '127.0.0.1 fnm-postgres' | sudo tee -a /etc/hosts`.
- These two `.env` files are gitignored; both must carry the same `DATABASE_URL`.

### Auth in local dev (`DEV_AUTH_BYPASS`) gotcha
- `apps/web/.env` sets `DEV_AUTH_BYPASS=true`, which makes the app act as the seeded client (`seed_client_1`, "Alex Morgan") for pages that read `getCurrentUser()` (homepage, `/jobs`, `/talents`, profiles).
- BUT `requireUser()` (in `src/lib/auth.ts`) throws when Clerk keys are absent *before* honoring the bypass, so pages/actions behind it (`/dashboard`, `/jobs/post`, `/profile`, save-search, proposals, payments, etc.) return HTTP 500 in local dev without Clerk. This is expected with the current code.
- To exercise authenticated flows locally, set real `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY` + `CLERK_SECRET_KEY` in `apps/web/.env` and restart. `/api/health` returns `ok:false` until Clerk is configured (DB still reports `ok`).
- The public waitlist form (`/jobs` empty-state when logged out) is a good no-auth end-to-end write path for smoke tests.

### Lint / test / build
- Lint is not wired up: the `lint` script runs `next lint`, which is removed in Next 16 (fails with "Invalid project directory ... /lint"), and there is no `eslint.config.*`. Use `npm run build` (root) for TypeScript type-checking instead.
- There are no automated tests in this repo (no test script/framework).
- `npm run build` builds `apps/web` and type-checks; `npm run dev` serves on port 3000.
- Optional integrations (Stripe, Resend, Vercel Blob) degrade gracefully when their env vars are unset — see `docs/ENVIRONMENT.md`.
