# Project Proposal — Cornerstone Retail

## Problem statement

A small local retail shop sells homewares, gifts, and accessories in-store and wants a simple web system to display products online, let registered customers place orders, and let staff manage inventory and fulfilment.

## Target users

| User | Needs |
|------|--------|
| **Shop admin** | Manage products, view all orders, update order status, audit activity |
| **Customer (standard user)** | Browse catalogue, search/filter products, manage cart, place and track orders |

## Core features

1. Secure login/register with role-based access (admin / user)
2. Product catalogue with search, filters, pagination
3. Shopping cart and checkout (creates orders, reduces stock)
4. Order history (users) and order management (admin)
5. Activity log and record-level audit fields
6. Help assistant (FAQ) and AI description drafting with human review

## Technology stack

| Layer | Choice | Justification |
|-------|--------|---------------|
| Front-end | HTML5, CSS3, JavaScript, Bootstrap 5 | Responsive UI, course-aligned, fast to deliver |
| Back-end | PHP 8+ (custom MVC-lite) | XAMPP-compatible, PDO, session auth |
| Database | MySQL | Relational data for products, orders, users |
| Version control | GitHub | Branches and pull requests per brief |
| AI | Local FAQ + template assistant | No external API; no PII exposure |

## Team roles (template — assign names)

| Role | Responsibilities |
|------|------------------|
| Team Lead | Backlog, milestones, GitHub workflow, presentation |
| Front-End Lead | Views, CSS, client validation, accessibility |
| Back-End Lead | Controllers, models, security, orders logic |
| Data/QA Lead | Schema, test cases, documentation |

## Milestones

| Milestone | Deliverable |
|-----------|-------------|
| M1 (Week 4–5) | This proposal, ERD, architecture (`docs/system-design.md`) |
| M2 (Week 7–8) | Auth + Products CRUD + DB |
| M3 (Week 11) | Orders, AI features, tests, deployment, final docs |

## Known limitations

See `docs/known-limitations.md`. Payment is simulated; AI is local/rule-based; product images via upload or URL.

---

*Document length: suitable for 2–3 pages when exported to Word (11pt, normal margins).*
