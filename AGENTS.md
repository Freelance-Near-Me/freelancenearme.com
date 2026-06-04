# Agent guide — Freelance Near Me

## Stack (authoritative)

- **App:** `apps/web` — Next.js 16, React 19, TypeScript, Tailwind CSS 4
- **DB:** `packages/database` — Prisma 7 + `@prisma/adapter-pg` + PostgreSQL (Neon)
- **Auth:** Clerk · **Payments:** Stripe Connect · **Email:** Resend · **Files:** Vercel Blob
- **Deploy:** Vercel (framework: Next.js)

## Do not extend

- `application/` — legacy PHP (CodeIgniter)
- `server/`, `client/` — archived MERN prototype

## Docs

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
