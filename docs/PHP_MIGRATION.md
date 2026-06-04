# PHP → React / Next.js migration

## Status

| Area | Status |
|------|--------|
| New user-facing app | **Live in `apps/web`** (React 19, Next.js 16, TypeScript) |
| Legacy PHP (`application/`, `ecadmin/`, `system/`) | **Frozen** — reference only, not deployed on Vercel |
| MERN spike (`server/`, `client/`) | **Frozen** — superseded by Next.js |
| Production database | **Postgres (Neon)** via Prisma — not legacy MySQL |
| Payments | **Stripe Connect** — not custom `ESCROW_WALLET` / PHP wallet code |

**Do not** add features to PHP. **Do** extend `apps/web` and `packages/database`.

## Domain mapping (legacy → modern)

| Legacy (PHP / MySQL) | Modern (Prisma / Next.js) |
|----------------------|---------------------------|
| User accounts + sessions | `User` + Clerk |
| Job / project posts | `Job` |
| Bids | `Proposal` |
| Hire / project room | `Contract` + `/contracts/[id]` |
| Milestones | `Milestone` |
| File uploads | `Deliverable` + Vercel Blob |
| Wallet / escrow PHP | Stripe Checkout + Transfer webhooks |
| Admin (`ecadmin/`) | Not ported — rebuild as Next.js admin when needed |

## Security after PHP retirement

1. **Rotate** any credentials that ever appeared in `application/config/database.php` (may exist in git history).
2. **Turn off** public PHP hosting for the old site when DNS points to Vercel.
3. **Do not** expose legacy MySQL to the internet once migration is complete.

## Data migration (when cutting over production)

1. Export users, jobs, bids, and milestones from MySQL (one-time script or ETL).
2. Transform to Prisma models; map IDs or use new CUIDs with a `legacyId` column if needed.
3. Seed Neon staging; run smoke tests on hire → fund → deliver flow.
4. Point `freelancenearme.com` DNS to Vercel; add redirects for high-traffic legacy URLs if required.

## Keeping PHP in the repo

The PHP tree remains for:

- Auditing old business rules (fees, statuses, edge cases)
- Legal/compliance review of historical behavior

It is excluded from Vercel builds via `.vercelignore`.
