# Environment variables

The production app lives in **`apps/web`**. Prisma CLI reads **`packages/database/.env`** (at minimum `DATABASE_URL`, matching the web app).

## Quick local setup

```bash
npm run setup:dev   # Docker Postgres, .env files, schema, seed
npm run dev         # http://localhost:3000
```

Or manually:

```bash
cp apps/web/.env.example apps/web/.env
# Edit DATABASE_URL, then:
echo "DATABASE_URL=\"<same-as-web>\"" > packages/database/.env
npm install && npm run db:push && npm run db:seed && npm run dev
```

---

## Variable reference

| Variable | Required | Where | Purpose |
|----------|----------|-------|---------|
| `DATABASE_URL` | **Yes** | Web + database package | PostgreSQL (Neon, Docker, or Prisma dev) |
| `NEXT_PUBLIC_APP_URL` | **Yes** (prod) | Web | Public site URL for redirects & links |
| `DEV_AUTH_BYPASS` | Local only | Web | `true` = skip Clerk, use seed users |
| `DEV_AUTH_USER` | Local only | Web | `client` (default) or `talent` when bypass on |
| `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY` | Prod | Web | Clerk frontend |
| `CLERK_SECRET_KEY` | Prod | Web | Clerk server / middleware |
| `CLERK_WEBHOOK_SECRET` | Prod | Web | Verify `/api/webhooks/clerk` |
| `NEXT_PUBLIC_CLERK_SIGN_IN_URL` | Prod | Web | Default `/sign-in` |
| `NEXT_PUBLIC_CLERK_SIGN_UP_URL` | Prod | Web | Default `/sign-up` |
| `NEXT_PUBLIC_CLERK_AFTER_SIGN_IN_URL` | Prod | Web | Default `/dashboard` |
| `NEXT_PUBLIC_CLERK_AFTER_SIGN_UP_URL` | Prod | Web | Default `/onboarding` |
| `NEXT_PUBLIC_CLERK_AFTER_SIGN_OUT_URL` | Prod | Web | Default `/` |
| `STRIPE_SECRET_KEY` | Payments | Web | Stripe API |
| `NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY` | Payments | Web | Stripe.js (if used client-side) |
| `STRIPE_WEBHOOK_SECRET` | Payments | Web | Verify `/api/webhooks/stripe` |
| `PLATFORM_FEE_PERCENT` | Optional | Web | Server fee calc (default `10`) |
| `NEXT_PUBLIC_PLATFORM_FEE_PERCENT` | Optional | Web | UI display (default `10`) |
| `RESEND_API_KEY` | Optional | Web | Transactional email |
| `EMAIL_FROM` | Optional | Web | Resend sender (default onboarding@resend.dev) |
| `BLOB_READ_WRITE_TOKEN` | Optional | Web | Vercel Blob deliverable uploads |

`NODE_ENV` is set automatically by Next.js / Vercel.

---

## Local profiles

### Minimal (browse UI, seed data)

```env
DATABASE_URL="postgresql://fnm:fnm_dev_password@localhost:5432/freelancenearme?schema=public"
DEV_AUTH_BYPASS=true
NEXT_PUBLIC_APP_URL=http://localhost:3000
NEXT_PUBLIC_PLATFORM_FEE_PERCENT=10
PLATFORM_FEE_PERCENT=10
```

Do **not** add `?pgbouncer=true` for Docker on port `5432`.

### Full integrations

Add Clerk, Stripe, Resend, and Blob keys from `apps/web/.env.example`.

---

## Vercel deployment

**Root Directory:** `apps/web` (or repo root with existing `vercel.json`).

Set these in **Project → Settings → Environment Variables** (Production + Preview):

| Variable | Notes |
|----------|--------|
| `DATABASE_URL` | Neon pooled URL; also available at build time |
| `NEXT_PUBLIC_APP_URL` | e.g. `https://freelancenearme.com` |
| `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY` | |
| `CLERK_SECRET_KEY` | |
| `CLERK_WEBHOOK_SECRET` | Production URL for webhook |
| `NEXT_PUBLIC_CLERK_*_URL` | As in `.env.example` |
| `STRIPE_SECRET_KEY` | Live or test per environment |
| `STRIPE_WEBHOOK_SECRET` | |
| `NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY` | |
| `PLATFORM_FEE_PERCENT` | e.g. `10` |
| `NEXT_PUBLIC_PLATFORM_FEE_PERCENT` | e.g. `10` |
| `RESEND_API_KEY` | |
| `EMAIL_FROM` | Verified domain in Resend |
| `BLOB_READ_WRITE_TOKEN` | Vercel Blob store |

**Do not** set `DEV_AUTH_BYPASS` on Vercel.

After first deploy, run migrations against production:

```bash
DATABASE_URL="..." npm run db:migrate
```

---

## Webhooks (production URLs)

| Service | Endpoint | Secret env |
|---------|----------|------------|
| Clerk | `https://<domain>/api/webhooks/clerk` | `CLERK_WEBHOOK_SECRET` |
| Stripe | `https://<domain>/api/webhooks/stripe` | `STRIPE_WEBHOOK_SECRET` |

Stripe events: `checkout.session.completed`, `account.updated`.

---

## Demo seed users

Used with `DEV_AUTH_BYPASS=true` or after Clerk sync:

| Role | Email | Clerk ID (bypass) |
|------|-------|-------------------|
| Client | `client@demo.freelancenearme.com` | `seed_client_1` |
| Talent | `talent@demo.freelancenearme.com` | `seed_talent_1` |
