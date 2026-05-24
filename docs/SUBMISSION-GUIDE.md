# Submission Guide — Assessment 3

Use this checklist to build your final **`A3-Submission/`** folder.

## Final folder structure

```
A3-Submission/
├── retail-shop.zip          # Zipped project (no vendor, no .env)
├── database.sql             # Copy from project root
├── README.md                # Copy from project root
├── github-link.txt          # Your repo URL
└── docs/
    ├── proposal.md          # Convert to .docx if required
    ├── system-design.md
    ├── page-flow.md
    ├── security-risk-register.md
    ├── test-cases.md
    ├── ai-governance.md
    ├── known-limitations.md
    ├── presentation.md      # Convert to presentation.pptx
    └── screenshots/         # PNG files (see below)
```

## 1. GitHub repository

- [ ] Create repo on GitHub (e.g. `cornerstone-retail`)
- [ ] Push full source including `README.md` and `/docs`
- [ ] Use branches: `main`, `develop`, `feature/products`, `feature/orders`, `feature/ai`
- [ ] At least 2–3 pull requests merged (or documented)
- [ ] Meaningful commit messages (e.g. `feat: add product CRUD`, `fix: CSRF on cart`)
- [ ] Paste URL in `github-link.txt`

**Example `github-link.txt`:**

```
https://github.com/YOUR_USERNAME/cornerstone-retail
```

## 2. Working application zip

Run from project folder:

```powershell
.\scripts\build-submission.ps1
```

Or manually zip the project as **`retail-shop.zip`**, excluding:

- `.git` (optional — include if brief allows)
- `public/setup.php` (delete first)
- uploaded images in `public/assets/uploads/products/*` (optional)

## 3. Database

- [ ] Include root **`database.sql`** (creates DB + tables + demo data)
- [ ] Verify import on a clean XAMPP install

## 4. Documentation

Markdown files in `/docs` cover deliverables A–E. Convert to `.docx` / `.pptx` if your lecturer requires Word/PowerPoint.

| Deliverable | File |
|-------------|------|
| A. Proposal | `proposal.md` |
| B. System design | `system-design.md`, `page-flow.md` |
| C. Risk register | `security-risk-register.md` |
| D. Test evidence | `test-cases.md` + `screenshots/` |
| E. AI governance | `ai-governance.md` |

## 5. Screenshots (required)

Save PNG files in `docs/screenshots/`:

| File | Content |
|------|---------|
| `01-login.png` | Login page |
| `02-register.png` | Register page |
| `03-catalogue.png` | Product catalogue (dashboard) |
| `04-product-crud.png` | Admin add/edit product |
| `05-search-filter.png` | Search or filter active |
| `06-pagination.png` | Page 2 of catalogue |
| `07-cart-checkout.png` | Cart or order success |
| `08-orders.png` | My orders / admin orders |
| `09-ai-description.png` | AI draft + disclaimer |
| `10-help-assistant.png` | Help FAQ answer |
| `11-activity-log.png` | Admin activity log |
| `12-validation-error.png` | Invalid login or form error |
| `13-access-denied.png` | User blocked from admin |
| `14-mobile-responsive.png` | Narrow browser / phone view |

## 6. Presentation (6–8 slides)

Outline in `docs/presentation.md` — copy into PowerPoint.

## 7. Team demo (10–12 min)

- Each member speaks 1–2 minutes  
- Live demo: login → catalogue → cart → order → admin product → AI draft → help  

## Pre-submit smoke test

1. Import `database.sql` on fresh XAMPP  
2. Login admin + user  
3. Place order, update status  
4. Generate AI description (edit before save)  
5. Confirm `setup.php` is **not** in zip  
