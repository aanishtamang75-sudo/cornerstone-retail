# Cornerstone Retail

**ICT203 Assessment 3** — Full-stack web application for a **small retail business** (product catalogue + online orders) with **responsible AI** integration.

## Project description

Cornerstone Retail is a secure, responsive, database-driven shop system. Customers browse products, search and filter the catalogue, manage a cart, and place orders. Administrators manage products (including images), update order status, and review audit and AI logs. AI assists with FAQ answers and draft product descriptions; **all AI-generated content requires human review before publishing.**

## Tech stack

| Layer | Technology |
|-------|------------|
| Front-end | HTML5, CSS3, JavaScript, Bootstrap 5 |
| Back-end | PHP 8+ (MVC-lite), Apache (XAMPP) |
| Database | MySQL (PDO, prepared statements) |
| Version control | Git / GitHub (branches, pull requests) |
| AI | Local rule-based FAQ + description assistant (no external API) |

## Team members and roles

_Update with your group before submission:_

| Name | Student ID | Role |
|------|------------|------|
| Anish Tamang | Cihe240555 | Team Lead / Scrum Master |
| _Member 2_ | _ID_ | Front-End Lead |
| _Member 3_ | _ID_ | Back-End Lead |
| _Member 3 or 4_ | _ID_ | Data / QA Lead |

## Setup steps (XAMPP)

1. Install [XAMPP](https://www.apachefriends.org/) (PHP 8+, MySQL).
2. Copy this project to `C:\xampp\htdocs\retail-shop`.
3. Start **Apache** and **MySQL** in XAMPP Control Panel.
4. Import the database (see below).
5. Open `http://localhost/retail-shop/public/index.php?route=login`.
6. **Do not submit** `public/setup.php` — use `database.sql` for markers; delete `setup.php` if present.

### Config

Edit `config/database.php` if MySQL credentials differ (default: user `root`, empty password).

## Database import steps

**Option A — phpMyAdmin (recommended)**

1. Open http://localhost/phpmyadmin  
2. Click **Import**  
3. Choose `database.sql` from this project root  
4. Click **Go**

**Option B — MySQL command line**

```bash
mysql -u root < database.sql
```

**Option C — Setup script (development only)**

Visit `http://localhost/retail-shop/public/setup.php` once, then delete that file.

Schema-only file: `database/schema.sql` (no demo data).

## Demo login credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@shop.demo | Admin123! |
| **User** | user@shop.demo | User123! |

## AI feature explanation

| Feature | What it does | Human review |
|---------|----------------|--------------|
| **Help assistant** | Answers system questions using curated FAQ (`data/faq.json`) | Read-only; no auto-save |
| **Description assistant** | Drafts product copy from name + rough notes (local rules) | **Required** — admin edits textarea before save |

- **No external AI APIs** — no customer PII sent to cloud services.  
- Disclaimer shown: *AI-generated content requires human review before publishing.*  
- Suggestions logged in `ai_suggestion_log` (Admin → AI log).

Details: `docs/ai-governance.md`

## Deployment link

| Environment | URL |
|-------------|-----|
| Local (XAMPP) | http://localhost/retail-shop/public/index.php?route=login |
| Production | _Not deployed — update if hosted_ |

## Documentation

| Document | Path |
|----------|------|
| Proposal | `docs/proposal.md` |
| System design | `docs/system-design.md` |
| Page flow | `docs/page-flow.md` |
| Security register | `docs/security-risk-register.md` |
| Test cases | `docs/test-cases.md` |
| AI governance | `docs/ai-governance.md` |
| Known limitations | `docs/known-limitations.md` |
| Submission guide | `docs/SUBMISSION-GUIDE.md` |
| Presentation outline | `docs/presentation.md` |

## Features (assessment checklist)

- [x] User authentication & roles (admin / user)  
- [x] CRUD: Products + Orders  
- [x] Search, filter, pagination  
- [x] Client + server validation  
- [x] Responsive UI  
- [x] Audit fields + activity log  
- [x] Responsible AI (Help + description draft)  
- [x] Product images (upload or URL)  

## Project structure

```
retail-shop/
├── config/
├── database/          # schema.sql, seed.sql
├── database.sql       # Full import for submission
├── data/              # FAQ for Help assistant
├── docs/              # Assessment documentation
├── public/            # Web root (index.php, assets)
├── src/               # PHP application code
└── views/             # HTML templates
```

## GitHub workflow

Use `main` + feature branches + pull requests. See `docs/SUBMISSION-GUIDE.md` for suggested commit history.

## Licence

Assessment project — CIHE ICT203.
