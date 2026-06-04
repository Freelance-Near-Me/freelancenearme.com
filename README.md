# Freelance Near Me

Modern freelance marketplace — **Next.js on Vercel**, **Neon Postgres**, **Clerk**, **Prisma**.

## Active application

| Path | Purpose |
|------|---------|
| `apps/web` | **Production app** — run this |
| `packages/database` | Prisma schema & client (`@fnm/database`) |
| `TASKS.md` | Systematic build checklist |
| `docs/PRODUCT_MODERNIZATION.md` | Strategy & phases |

Legacy: `application/` (PHP), `server/` + `client/` (MERN prototype) — do not extend.

## Quick start

```bash
npm install

# Database (Docker)
docker compose up -d

# Env: copy and set DATABASE_URL + Clerk keys
cp apps/web/.env.example apps/web/.env
cp packages/database/.env.example packages/database/.env
# Use the same DATABASE_URL in both .env files

npm run db:push      # apply schema (dev)
npm run db:seed      # demo jobs + users
npm run dev          # http://localhost:3000
```

### Local dev without Clerk

```env
# apps/web/.env
DEV_AUTH_BYPASS=true
DATABASE_URL=postgresql://...
```

Uses seed client user for auth. **Never enable in production.**

### Clerk setup

1. Create app at [clerk.com](https://clerk.com) or Vercel Marketplace  
2. Set `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY` and `CLERK_SECRET_KEY` in `apps/web/.env`  
3. After sign-up, users complete `/onboarding`
4. **Webhook:** In Clerk Dashboard → Webhooks → add endpoint  
   `https://your-domain.com/api/webhooks/clerk`  
   Subscribe to `user.created`, `user.updated`, `user.deleted`  
   Copy signing secret to `CLERK_WEBHOOK_SECRET`

After schema changes: `npm run db:push` (or `db:migrate` for production).

## Scripts

| Command | Description |
|---------|-------------|
| `npm run dev` | Next.js dev server |
| `npm run build` | Production build |
| `npm run db:push` | Push Prisma schema |
| `npm run db:migrate` | Create migration |
| `npm run db:seed` | Demo data |
| `npm run db:studio` | Prisma Studio |

## Deploy to Vercel

1. Import repo on Vercel  
2. Set **Root Directory** to `apps/web` (recommended) or leave at repo root — both work with the included `vercel.json` files  
3. **Framework Preset** must be **Next.js** (not Jekyll). If deploy fails looking for `_site`, clear **Output Directory** in project settings and redeploy.  
4. Add integration: **Neon** → `DATABASE_URL`  
5. Add **Clerk**, **Stripe**, **Resend**, and **Blob** env vars (see `apps/web/.env.example`)  
6. Run migrations against production: `npm run db:migrate`

## Core user flow (implemented)

1. **Client** posts job → `/jobs/post`  
2. **Talent** submits proposal on job page  
3. **Client** shortlists → **Send offer** → contract  
4. **Talent** accepts contract → `/contracts/[id]`  

### Stripe & email (Phase 2)

1. Stripe Dashboard → Connect → enable Express accounts  
2. Webhook: `https://your-domain.com/api/webhooks/stripe`  
   Events: `checkout.session.completed`, `account.updated`  
3. Resend: verify domain or use `onboarding@resend.dev` for dev  
4. Talent: **Dashboard → Payout settings** before clients can fund milestones  

**Milestone payment flow:** Client funds (Checkout) → `FUNDED` → Talent submits → Client approves → Stripe transfer to talent.

### Work delivery (Phase 3)

1. Vercel project → Storage → Blob → `BLOB_READ_WRITE_TOKEN` in `apps/web/.env`  
2. Contract workspace: upload deliverables per funded milestone, activity sidebar, in-app notifications at `/notifications`  
3. Events also create `Notification` rows (proposals, offers, milestones, deliverables, messages on active contracts)

## Demo seed logins

Mapped to `clerkId` placeholders until Clerk sync:

- Client: `client@demo.freelancenearme.com`  
- Talent: `talent@demo.freelancenearme.com`  

Use with `DEV_AUTH_BYPASS=true` or link Clerk users via webhook (Phase 1 task).
