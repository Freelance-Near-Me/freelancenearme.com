# Phase 0 Spike — Mercur as a FreelanceNearMe foundation

**Verdict: PROCEED (with eyes open).** Mercur's schema bends to a freelance/services model without a structural fight. The vendor, catalog, order, and — critically — the payment/payout/commission primitives map cleanly onto freelancer / service-listing / contract / milestone-escrow concepts. The friction points found are localized (shipping-profile coupling, a canary version-drift install snag, and the milestone state machine being net-new), not foundational.

This document answers the three Phase 0 schema questions with evidence pulled from a real, migrated, seeded Mercur instance. The full schema (domain-relevant subset) is in [`schema-dump.sql`](./schema-dump.sql).

---

## What was actually run

| Step | Result |
|------|--------|
| Scaffold | `npx create-mercur-app@latest create freelancenearme-spike -t basic` (bun unavailable → npm fallback), **with** Next.js storefront |
| Services | Native PostgreSQL 16 + Redis 7 (Docker unavailable in this VM; substituted native services — same connection strings) |
| DB | `mercur_spike` on Postgres 5432 |
| Migrations | `medusa db:migrate` → **200 tables** created (all Medusa commerce modules + Mercur marketplace modules) |
| Seed | `medusa exec src/scripts/seed.ts` → **3 sellers, 12 products, 244 offers**, regions/sales-channel/API keys |
| Backend boot | `medusa develop` → **"Server is ready on port 9000"**; `/health` 200, `/dashboard` (admin) 200, `/seller` (vendor panel) 200, `/store/products` 400 (correctly demands publishable key) |
| Admin user | Created via `medusa user` (super admin) — admin auth path works |
| Checkout | **Not completed live.** See "Checkout" note below — deferred to Phase 1 (needs sales-channel/inventory wiring + Stripe test keys, which Phase 1 provides). |

### Install gotcha worth flagging for Phase 1 (real risk)
Mercur is published as **canary** (`@mercurjs/core@2.3.0-canary.0`) pinned against `@medusajs/*@2.17.2`. Out of the box the install is inconsistent: the bundled storefront (`@mercurjs/storefront@2.1.1`) drags `@mercurjs/core@2.2.0` to the hoisted root, while the backend needs `2.3.0-canary.0` (the 2.2.0 build is missing modules like `promotion-cost`/`review`), so `medusa db:migrate` fails with `Cannot find module '.../@mercurjs/core/.medusa/server/src/modules/promotion-cost/index.js'`. Fixed here by pinning `@mercurjs/core`/`@mercurjs/types` to the canary at the root (`overrides` + root dep). **Implication:** building on a canary line means version pinning and lockfile discipline are a Phase-1 must; expect this to move under us until Mercur cuts a stable 2.3.

---

## Q1 — Can "product" become "service listing" without fighting inventory/shipping?

**Yes, largely clean — one coupling to handle.**

Evidence from `product` (see dump): every physical attribute is **nullable** —
`weight`, `length`, `height`, `width`, `origin_country`, `hs_code`, `mid_code`, `material` — and `is_giftcard` defaults `false`. Nothing forces a service listing to carry shipping dimensions. Inventory in Medusa v2 is a separate module; a variant can set `manage_inventory = false`, so a service isn't forced to track stock. So "product → service listing" is a matter of hiding fields in the vendor UI (Phase 2b) and adding `service_type` / `delivery_time_days` / `revisions_included`, exactly as the build sheet plans — no schema fight.

**The one wrinkle:** Mercur's `offer` table (its per-seller listing/SKU on a shared catalog) has `shipping_profile_id NOT NULL`, and the fulfillment layer assumes a shipping step. Services will need a "no-op" / digital shipping profile (or a manual fulfillment provider) so listings and checkout don't demand a real shipment. This is a known Medusa pattern (digital/service products), not a blocker — but it is a required Phase 2b task, not something you get for free.

**Naming caution:** in Mercur, **`offer` is NOT a proposal/quote.** It is a seller's variant-level listing (`sku`, `ean`, `upc`, `variant_id`, `shipping_profile_id`; 244 seeded across 3 sellers). The freelance "Proposal" (Phase 2d) remains net-new; don't try to overload `offer` for it.

## Q2 — Can "order" become "contract" cleanly, or does single-checkout resist a staged/milestone model?

**"Order = contract container" is workable; a native staged/milestone model is NOT built-in, but the single-checkout flow does not actively resist layering one on.**

What helps (evidence):
- The `order` is a **versioned, mutable aggregate** (`order.version`, `order_status_enum`) with a full change/ledger surface: `order_change`, `order_change_action`, `order_edit`, `order_exchange`, `order_claim`, `order_transaction`, `order_summary`, plus `order_item` distinct from `order_line_item`. Orders are not treated as immutable one-shot receipts.
- Payments are decoupled from orders via `payment_collection` → `payment_session` → `payment`, and money movement is itself staged: **`payment.captured_at` is nullable** and there are dedicated **`capture`** (partial captures, `amount` per row, FK `payment_id`) and **`refund`** tables. Multiple captures per payment are a first-class concept.

What's missing / the honest friction:
- There is **no milestone entity** and no notion of "fund now, capture later in slices tied to deliverables." A milestone is finer-grained than anything Medusa models.
- The default storefront checkout is still fundamentally **cart → one order**. Rather than fighting that, the clean shape is: **one milestone = one `payment_collection` (manual-capture) against the contract's order**, so "funding milestones" = creating/authorizing N payment collections over time, and "release" = capturing that collection. The order becomes the contract container; milestones are a child module driving the existing payment/capture primitives. This layers on; it does not require forking the checkout.

So: `order → contract` is a clean mapping *as a container*; the milestone lifecycle is net-new module work (Phase 2e), which the build sheet already treats as the slow, high-review phase.

## Q3 — Smallest viable custom milestone module (given Stripe Connect + Medusa's payment module)

**Small — mostly a state machine + links. The money primitives already exist; you are orchestrating them, not reimplementing them.**

Already provided by Medusa/Mercur (evidence):
- **Auth/capture escrow primitive:** Medusa payment module + `capture`/`refund` tables + `payment.captured_at`. The Medusa Stripe provider supports `capture_method: manual`, which IS the escrow mechanism the sheet mandates. `payment.data` (jsonb) stores the Stripe PaymentIntent id/status.
- **Marketplace payouts / Stripe Connect abstraction:** `payout`, `payout_account` (status `pending|active|restricted|rejected`, `data`/`context` jsonb), and `onboarding` (`account_id`, `data`/`context` jsonb). This is exactly the connected-account + transfer/payout layer. Note the payout **provider is pluggable** — `@mercurjs/core` ships the payout *module* but no bundled Stripe provider in this build (`providers/` is empty), so the Stripe Connect provider is a Phase-1/2e integration, not free.
- **Configurable platform fee:** `commission_rule` → `commission_rate` → `commission_rate_value` + `commission_line`. The "make the fee a configurable percentage, not hardcoded" requirement is already a modeled concept — reuse it instead of an env var if you want per-category/per-seller fees.
- **Seller payout details already modeled:** `payment_details` (IBAN/BIC/account/routing per seller) and `professional_details` (corporate_name, registration_number, tax_id) — useful for KYC/verification (Phase 4) and payouts.

So the **net-new custom module** is essentially:
1. `Contract` (job_id, proposal_id, client_id, freelancer_id, status) and `Milestone` (contract_id, amount, `status ∈ {pending_funding, funded, submitted, approved, released, disputed, capture_succeeded_transfer_failed}`, `stripe_payment_intent_id`, due_date) — as the sheet specifies.
2. A **link** from Milestone → `payment_collection`/`payment` and Milestone-release → `payout` + `commission` line.
3. A **webhook-driven state machine** (`payment_intent.succeeded|canceled`, `transfer.created`) with event-id dedupe. Medusa's workflow/subscriber system + the modules above give you the transaction and idempotency scaffolding; you write the milestone transitions and the compensations (e.g. `capture_succeeded_transfer_failed`).

Estimate of invasiveness: one custom module (2 entities + links + workflows/subscribers) plus wiring the Medusa Stripe payment provider (manual capture) and a Stripe Connect payout provider. You are not rebuilding capture, refund, payout, onboarding, or commission — those are present.

---

## Checkout note (why it wasn't completed live)

A live Store-API checkout was attempted with the default system payment provider (no Stripe keys in this spike env). It failed at cart creation (`get-variants-and-items-with-prices … calculated_amount undefined`). Root cause is demo-seed wiring, not a schema limitation: the seed leaves `product_sales_channel` **empty** (0 rows), so variant availability/pricing can't resolve for the publishable key's sales channel. Completing checkout needs the standard Medusa sales-channel + inventory + shipping-option setup and (per the build sheet) Stripe test keys — all of which are Phase 1 scope. Vendor + product + offer creation were exercised via the seed (3 sellers / 12 products / 244 offers), and the backend + admin + vendor + store APIs all serve, so the foundation itself is sound.

## Recommendation

Proceed to Phase 1 on Mercur. Carry these into Phase 1/2 planning:
1. **Pin versions / commit a lockfile** and re-verify on each Mercur bump — the canary line is unstable (the migrate-breaking core mismatch above).
2. **Add a service/digital shipping profile (or manual fulfillment)** early so service listings and milestone checkouts don't demand shipments (Q1 wrinkle).
3. **Model milestones as manual-capture `payment_collection`s against a contract-order**, reusing `capture`/`refund`/`payout`/`commission` rather than inventing money movement (Q2/Q3).
4. **Reuse `commission_rule`/`commission_rate`** for the platform fee; consider it over a single env var if per-seller/per-category fees are ever wanted.
5. Don't overload Mercur's `offer` for freelancer proposals — keep Proposal net-new (Phase 2d).
