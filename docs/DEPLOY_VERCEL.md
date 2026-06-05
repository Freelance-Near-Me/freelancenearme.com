# Deploy on Vercel (monorepo)

The Next.js app lives in **`apps/web`**. The build writes `.next` to `apps/web/.next`, not the repository root.

## Recommended project settings

In **Vercel → Project → Settings → General**:

| Setting | Value |
|---------|--------|
| **Root Directory** | `apps/web` |
| **Framework Preset** | Next.js |
| **Build Command** | *(leave empty — uses `apps/web/vercel.json`)* |
| **Output Directory** | *(leave empty — do not use `_site` or a custom path)* |
| **Install Command** | *(leave empty — uses `apps/web/vercel.json`)* |

With **Root Directory = `apps/web`**, Vercel runs the build from the app folder and finds `.next` at the project root automatically.

Environment variables: [ENVIRONMENT.md](./ENVIRONMENT.md).

---

## If Root Directory is the repo root (`.`)

The root [`vercel.json`](../vercel.json) runs the workspace build and symlinks `apps/web/.next` → `.next` so the Next.js builder can find the output.

Prefer setting **Root Directory** to `apps/web` instead — simpler and avoids path issues.

---

## Common errors

| Error | Fix |
|-------|-----|
| `.next` not found at `/vercel/path0/.next` | Set **Root Directory** to `apps/web`, or use root `vercel.json` (symlink). Clear **Output Directory** override. |
| `_site` / Jekyll output | Remove **Output Directory** override; framework must be **Next.js**. |
| `DATABASE_URL` on install | Fixed in `prisma.config.ts` (placeholder for `prisma generate`). |

---

## Build commands (reference)

From repo root:

```bash
npm install
npm run db:generate
npm run build -w web
```

Production DB:

```bash
DATABASE_URL="..." npm run db:migrate
```
