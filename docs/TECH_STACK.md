# Tech stack — Freelance Near Me v3

The production application is a **TypeScript React** app on **Next.js**. Legacy **PHP (CodeIgniter)** is archived in the repo for reference only and is **not deployed**.

## Production stack

| Layer | Technology | Role |
|-------|------------|------|
| **Language** | TypeScript 5.x | End-to-end type safety |
| **UI** | React 19 + Next.js 16 (App Router, Turbopack) | Server & client components, routing, SSR |
| **Styling** | Tailwind CSS 4 | Layout and design tokens |
| **Auth** | Clerk | Sign-in, sessions, roles (`client` / `talent`) |
| **Database** | PostgreSQL (Neon) + Prisma 7 (`@prisma/adapter-pg`) | Users, jobs, proposals, contracts, milestones |
| **Payments** | Stripe Connect | Milestone escrow, payouts, platform fee |
| **Email** | Resend | Transactional notifications |
| **Files** | Vercel Blob | Contract deliverables |
| **Hosting** | Vercel | Builds, previews, serverless functions |

## Repository layout

```
apps/web/              ← Run this. Next.js React application
packages/database/     ← Prisma schema, migrations, @fnm/database client
docs/                  ← Product and migration documentation
application/           ← ARCHIVED PHP (CodeIgniter) — do not run or extend
server/ + client/      ← ARCHIVED MERN spike — do not extend
```

## How we build features

- **UI:** React components in `apps/web/src/components/` and route pages under `apps/web/src/app/`.
- **Data & mutations:** Prisma in `packages/database` + **Server Actions** in `apps/web/src/actions/`.
- **API webhooks:** Route handlers in `apps/web/src/app/api/` (Clerk, Stripe).
- **Auth:** `middleware.ts` + `lib/auth.ts` (Clerk; optional `DEV_AUTH_BYPASS` locally only).

## What we retired

| Legacy | Replaced by |
|--------|-------------|
| PHP / CodeIgniter (`application/`) | Next.js App Router |
| PHP sessions + MD5 passwords | Clerk |
| MySQL + custom wallet tables | Neon Postgres + Stripe Connect |
| jQuery / Bootstrap admin UI | React + Tailwind |
| MERN prototype (`server/` + `client/`) | Same Next.js app (single deploy) |

See [PHP_MIGRATION.md](./PHP_MIGRATION.md) for module mapping and data migration notes.

## Version policy (2026)

| Package | Pinned | Notes |
|---------|--------|-------|
| Next.js | 16.x | Turbopack default; Node **20.9+** required |
| Clerk | 7.x | Async `auth()` / `clerkClient()`; `<Show>` for signed-in UI |
| Prisma | 7.x | `prisma.config.ts`, generated client, `@prisma/adapter-pg` |
| Zod | 4.x | Form validation in server actions |
| Stripe | 22.x | Connect checkout, transfers, webhooks |

## Planned additions (Phase 4+)

- Typesense (search), Upstash Redis (rate limits), Ably/Pusher (realtime), Sentry (errors), PostHog (analytics)
