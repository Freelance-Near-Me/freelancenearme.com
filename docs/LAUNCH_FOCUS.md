# Launch focus

Freelance Near Me launches one category in one geography at a time so both sides of the marketplace have liquidity on day one.

## Current focus (demo / staging)

| Dimension | Value |
|-----------|--------|
| Category | Development (React, Node.js) |
| Geography | Greater Manchester, UK |
| Postcode anchor | M1 1AA |

## Before public launch

1. Onboard at least 10 verified freelancers in the focus category and region.
2. Publish 3 to 5 real client jobs in the same category and region.
3. Hide or gate categories with zero open jobs (see `/categories`).
4. Capture waitlist sign-ups for other postcodes via the jobs empty state and homepage.

## Marketing alignment

- Homepage hero and CTAs should mention local hiring in the focus region.
- SEO titles should include the city or region where possible.
- Do not run paid acquisition outside the launch geography until waitlist demand justifies expansion.

## Admin runbook

- Create demo or real users via Clerk sign-up (not seed `clerkId` rows alone).
- Use `npm run db:seed` only for local development.
- Stripe Connect and Clerk webhooks must be configured on Vercel before onboarding paying clients.
