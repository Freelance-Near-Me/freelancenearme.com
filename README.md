# Freelance Near Me

A **TypeScript React** freelance marketplace built with **Next.js 16**, deployed on **Vercel**, backed by **Neon Postgres**.

The legacy **PHP (CodeIgniter)** site in `application/` is **retired** — kept in the repo for reference only. All new work happens in `apps/web`.

## Tech stack

| | |
|---|---|
| **Language** | TypeScript |
| **Frontend** | React 19, Next.js App Router, Tailwind CSS 4 |
| **Backend** | Next.js Server Actions + API routes (no PHP) |
| **Database** | PostgreSQL + Prisma 7 (`packages/database`, `@prisma/adapter-pg`) |
| **Auth** | Clerk |
| **Payments** | Stripe Connect (milestone escrow) |
| **Email** | Resend |
| **Files** | Vercel Blob |

Full details: [docs/TECH_STACK.md](docs/TECH_STACK.md) · PHP retirement: [docs/PHP_MIGRATION.md](docs/PHP_MIGRATION.md)

## Repository

| Path | Status |
|------|--------|
| `apps/web` | **Production app** — React / Next.js |
| `packages/database` | Prisma schema & client |
| `docs/` | Product, stack, migration guides |
| `TASKS.md` | Build checklist |
| `application/` | Archived PHP — do not run |
| `server/`, `client/` | Archived MERN spike — do not extend |

## Quick start

```bash
# 1. Start Postgres + install deps + schema + seed
npm run setup:dev

# 2. Run the app
npm run dev
# → http://localhost:3000
```

`setup:dev` uses Docker Postgres when available; otherwise it starts **Prisma local Postgres** (`npx prisma dev --detach`). The repo includes `apps/web/.env` and `packages/database/.env` for local dev (gitignored if you regenerate them).

If port 3000 is busy: `npm run dev -w web -- --port 3002`

**Manual setup** (if you prefer step by step):

```bash
docker compose up -d
npm install
npm run db:push
npm run db:seed
npm run dev
```

### Local dev without Clerk

`apps/web/.env` should include:

```env
DEV_AUTH_BYPASS=true
DATABASE_URL="postgresql://fnm:fnm_dev_password@localhost:5432/freelancenearme?schema=public"
```

- Default signed-in user: **client** (`Alex` / `client@demo.freelancenearme.com`)
- Talent flows: set `DEV_AUTH_USER=talent` and restart dev server

Never enable `DEV_AUTH_BYPASS` in production.

### Optional integrations (local)

| Variable | Purpose |
|----------|---------|
| Clerk keys | Real sign-in instead of bypass |
| `STRIPE_*` | Milestone payments |
| `RESEND_API_KEY` | Transactional email |
| `BLOB_READ_WRITE_TOKEN` | Deliverable uploads |

### Clerk

1. Create an app at [clerk.com](https://clerk.com)  
2. Set `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY` and `CLERK_SECRET_KEY`  
3. Webhook: `https://your-domain.com/api/webhooks/clerk` → `CLERK_WEBHOOK_SECRET`

## Scripts

| Command | Description |
|---------|-------------|
| `npm run dev` | Next.js dev server (React app) |
| `npm run build` | Production build |
| `npm run db:push` | Apply Prisma schema |
| `npm run db:migrate` | Create migration |
| `npm run db:seed` | Demo data |
| `npm run db:studio` | Prisma Studio |

## Deploy to Vercel

1. Import repo · **Framework:** Next.js · **Root Directory:** `apps/web` (recommended)  
2. Clear any **Output Directory** override (must not be `_site` from old Jekyll/GitHub Pages)  
3. Integrations: Neon (`DATABASE_URL`), Clerk, Stripe, Resend, Blob — see `apps/web/.env.example`  
4. `npm run db:migrate` against production

## Product flows (implemented)

Hire loop: post job → proposals → offer → contract → fund milestones (Stripe) → deliverables (Blob) → approve & payout.

Marketing: `/`, `/jobs`, `/talents`, `/how-it-works`, `/freelancers/[username]`.

## Demo users (seed)

- Client: `client@demo.freelancenearme.com`  
- Talent: `talent@demo.freelancenearme.com`  

Use with `DEV_AUTH_BYPASS=true` or Clerk webhook sync.
