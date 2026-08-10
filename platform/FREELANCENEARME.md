# FreelanceNearMe — Phase 1 skeleton (Mercur foundation)

This directory (`platform/`) is the **Phase 1 rebuild skeleton**: a fresh [Mercur](https://github.com/mercurjs/mercur) (Medusa v2) marketplace, branded as FreelanceNearMe, with **nothing custom yet** (domain remodelling is Phase 2). It was scaffolded with `create-mercur-app` (`basic` template + Next.js storefront).

> Placement note: this lives inside the existing `freelancenearme.com` repo because the cloud agent can't create the intended Digiteq org repo. It is a self-contained npm workspace and is meant to be **relocated to its own repo** (see "Blocked / needs input").

## Layout
- `packages/api` — Medusa backend + Mercur marketplace modules (seller, commission, offer, payout, review, …)
- `apps/admin` — admin dashboard extensions · `apps/vendor` — vendor portal · `apps/storefront` — Next.js storefront (rebranded)

## Local dev

Prereqs: Node ≥ 20, Postgres, Redis. Compose is provided (`docker compose up -d`) — **note the Mercur `basic` template does not ship one; it was added here.** In this cloud VM, Docker was unavailable, so native Postgres 16 + Redis 7 were used with identical creds/ports; the compose file is verified by inspection.

```bash
# 1. services (or run native Postgres+Redis with matching creds)
docker compose up -d
# 2. env
cp packages/api/.env.example packages/api/.env         # set DATABASE_URL, REDIS_URL, secrets
cp apps/storefront/.env.example apps/storefront/.env.local  # set NEXT_PUBLIC_MEDUSA_PUBLISHABLE_KEY
# 3. install (see version-pin note below)
npm install
# 4. db + seed
cd packages/api && npx medusa db:migrate && npm run seed && npx medusa user -e admin@fnm.test -p supersecret123
# 5. run
cd packages/api && npm run dev        # backend :9000, admin /dashboard, vendor /seller
cd apps/storefront && npm run dev      # storefront :3000 (used :3005 in the VM to avoid a port clash)
```

The storefront's publishable key comes from the seeded `api_key` (or the admin UI). Default region for the storefront is `gb` (the seed's "Europe" region includes GB).

## ⚠️ Version-pin gotcha (must keep)

Mercur ships as **canary** (`@mercurjs/core@2.3.0-canary.0`) pinned against `@medusajs/*@2.17.2`. Out of the box the install is inconsistent: the storefront (`@mercurjs/storefront@2.1.1`) drags `@mercurjs/core@2.2.0` to the hoisted root while the backend needs the canary (the 2.2.0 build is missing modules like `promotion-cost`/`review`), so `medusa db:migrate` fails with `Cannot find module '.../@mercurjs/core/.medusa/server/src/modules/promotion-cost/index.js'`.

Fix applied in `package.json` (keep it): `@mercurjs/core` + `@mercurjs/types` pinned to `2.3.0-canary.0` in both root `dependencies` and `overrides`. Re-verify on every Mercur bump until a stable 2.3 ships. (npm registry rate-limits big installs; `npm install --prefer-offline` uses the warm cache.)

## Rebrand (Phase 1, stubbed)
- Brand palette: `apps/storefront/src/app/colors.css` `--brand-*` → **stub ochre/amber** (replace with final tokens).
- Logo: `apps/storefront/public/Logo.svg` → **stub** FreelanceNearMe wordmark (replace with final asset; favicon still default).
- Copy: homepage hero, section headings, metadata, footer rebranded; default Mercur "Fleek" demo sections (ShopByStyle/Blog/Banner) stripped.
- Site name/description via `NEXT_PUBLIC_SITE_NAME` / `NEXT_PUBLIC_SITE_DESCRIPTION`.

Seed data is still Mercur's demo **physical goods** (footwear) — product→service remapping is Phase 2b.

## Phase 1 status
- Local dev running: **yes** (backend + storefront verified).
- Stripe Connect test onboarding + payout: **blocked** — needs Stripe test keys.
- Staging deploy: **blocked** — needs Digiteq org repo + hosting decision.

## Blocked / needs input (to finish Phase 1)
1. **Stripe test keys** (`STRIPE_SECRET_KEY`, `STRIPE_WEBHOOK_SECRET`, `STRIPE_CONNECT_CLIENT_ID`) — for the vendor onboarding + test-payout walkthrough (step 5).
2. **Digiteq GitHub org repo + hosting path** (Vercel for storefront/admin; VPS or managed Postgres for backend) — to move this skeleton out and wire staging + CI (step 6).
3. **Final brand tokens** (colors, fonts, logo, favicon) — to replace the stubs above (step 4).
