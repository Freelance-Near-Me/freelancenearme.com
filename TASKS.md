# Build task list — Freelance Near Me v3

Track progress here. **Active app:** `apps/web` (Next.js). **Database:** `packages/database` (Prisma + Neon).

Legend: `[ ]` todo · `[~]` in progress · `[x]` done

---

## Phase 0 — Foundation

- [x] Monorepo workspaces (`apps/web`, `packages/database`)
- [x] Prisma schema (users, jobs, proposals, contracts, skills)
- [x] Next.js App Router scaffold + shared UI components
- [x] `TASKS.md` + `docs/PRODUCT_MODERNIZATION.md`
- [x] Production build verified (`npm run build -w web`)
- [ ] Link Vercel project + Neon (`vercel integration add neon`)
- [x] Clerk webhook route (`/api/webhooks/clerk` + `CLERK_WEBHOOK_SECRET`)
- [ ] Configure Clerk in Vercel (`NEXT_PUBLIC_CLERK_*`, webhook URL)
- [ ] Run first migration on Neon staging (`npm run db:migrate`)
- [ ] Rotate legacy PHP DB credentials (security)

## Phase 1 — Core marketplace loop (current focus)

### Auth & onboarding
- [x] Clerk middleware + protected routes (optional dev bypass)
- [x] Role metadata: `client` | `talent`
- [x] Onboarding: choose role + basic profile (`/onboarding`)
- [x] Clerk webhook: sync `User` row on `user.created` / `user.updated`
- [x] Profile edit (`/profile` — headline, bio, skills, hourly rate)

### Jobs
- [x] Public job listing + search query param
- [x] Job detail page (slug URL)
- [x] Post job (clients only, server action)
- [x] Job drafts + edit (`/jobs/[slug]/edit`)
- [x] Job skills multi-select

### Proposals
- [x] Talent: submit proposal on open job
- [x] Client: proposal inbox per job
- [x] Shortlist / decline proposal (status)
- [x] Proposal messaging thread (`/jobs/[slug]/chat/[talentId]`)

### Contracts
- [x] Send offer from shortlisted proposal → Contract
- [x] Contract workspace shell (`/contracts/[id]`)
- [x] Accept offer (talent) → active contract
- [x] Milestone model + UI on contract page (Stripe funding Phase 2)

### Marketing
- [x] Intent-first homepage (Hire / Find work)
- [x] Static pages: about, how-it-works
- [x] Talent directory page (`/talents`)
- [x] Public freelancer profile `/freelancers/[username]`

## Phase 2 — Trust & money

- [x] Stripe Connect Express onboarding (`/settings/payouts`)
- [x] Milestone funding via Stripe Checkout (escrow on platform balance)
- [x] Payout release on approve (Stripe Transfer + platform fee)
- [x] Stripe webhooks (`/api/webhooks/stripe`)
- [x] Resend transactional emails (proposal, offer, accept, fund, payout)
- [ ] Sentry error monitoring
- [ ] Production Stripe/Resend keys on Vercel

## Phase 3 — Work delivery

- [x] Deliverables (Vercel Blob) — upload per funded milestone on contract page
- [x] Contract activity timeline — logged on offer/accept/milestones/payments/deliverables/messages
- [x] In-app notifications — `/notifications` + unread badge in header

## Phase 4 — Discovery

- [ ] Typesense job/talent search
- [ ] Saved searches + Vercel Cron alerts
- [ ] Reviews + success score

## Deprecated / reference only

- `server/` + `client/` — MERN prototype (do not extend)
- `application/` — legacy PHP (read-only)
