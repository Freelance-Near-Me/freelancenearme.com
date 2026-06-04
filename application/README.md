# Legacy PHP application (archived)

**This directory is not part of the production application.**

Freelance Near Me v3 runs as a **React / Next.js** app in [`../apps/web`](../apps/web) with **PostgreSQL** and **Clerk**.

## What this is

- **CodeIgniter** PHP monolith (HMVC modules under `application/modules/`)
- Former production stack: PHP sessions, MySQL, custom wallet/escrow, jQuery UI

## Rules

- **Do not** deploy this code to Vercel or new servers
- **Do not** add features or fix bugs here unless extracting behavior for the Next.js port
- **Do** read this code when mapping legacy flows — see [`../docs/PHP_MIGRATION.md`](../docs/PHP_MIGRATION.md)

## Security

Database credentials may exist in `config/database.php` in git history. Rotate all legacy DB and payment keys if this repo was ever public.
