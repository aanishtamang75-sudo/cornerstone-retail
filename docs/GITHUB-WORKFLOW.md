# GitHub Workflow — Cornerstone Retail

## Repository

**URL:** See `github-link.txt` in project root.

## Branch strategy

| Branch | Purpose |
|--------|---------|
| `main` | Stable release for submission |
| `develop` | Integration branch |
| `feature/auth` | Authentication & roles |
| `feature/products` | Product catalogue & CRUD |
| `feature/orders` | Cart, checkout, orders |
| `feature/ai` | Help assistant & description AI |

## Pull requests (for assessment evidence)

After pushing, open PRs on GitHub:

1. `feature/auth` → `develop` — *feat: user authentication and role-based access*
2. `feature/products` → `develop` — *feat: product catalogue with search and admin CRUD*
3. `feature/orders` → `develop` — *feat: shopping cart and order management*
4. `feature/ai` → `develop` — *feat: responsible AI help and description assistant*
5. `develop` → `main` — *release: Assessment 3 MVP*

Screenshot PR merge history for individual contribution evidence.

## Suggested commit messages (already in history)

- `chore: project scaffold, database schema, and MVC bootstrap`
- `feat(auth): login, register, sessions, and role checks`
- `feat(products): catalogue search filter pagination and admin CRUD`
- `feat(orders): cart checkout and order status management`
- `feat(ai): FAQ help assistant and description drafting with audit log`
- `feat(ui): product image upload and responsive empty states`
- `docs: assessment documentation and submission guide`
