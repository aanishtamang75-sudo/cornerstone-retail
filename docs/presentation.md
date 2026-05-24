# Presentation Outline (6–8 slides)

_Copy into PowerPoint (`presentation.pptx`). Each member should present 1–2 slides._

---

## Slide 1 — Title

**Cornerstone Retail**  
ICT203 Assessment 3 — Full-Stack Web Application  

Team: _[Names]_  
Roles: Team Lead, Front-End, Back-End, Data/QA  

---

## Slide 2 — Problem statement

- Small retail shop needs an online **catalogue** and **order** system  
- Staff must manage products and fulfilment  
- Customers need secure accounts and order history  
- Solution must include **responsible AI**, not unsafe automation  

---

## Slide 3 — Features

- Login / register with **admin** and **user** roles  
- Product CRUD, images, search, filter, pagination  
- Shopping cart and checkout (simulated payment)  
- Order tracking and admin status updates  
- Activity log and audit fields  
- AI Help assistant + description drafting  

---

## Slide 4 — Architecture & ERD

- **Client:** Browser (HTML, CSS, JS, Bootstrap)  
- **Server:** PHP MVC-lite on Apache (XAMPP)  
- **Database:** MySQL via PDO  

_Show architecture diagram and ERD from `docs/system-design.md`_

---

## Slide 5 — Security

| Risk | Mitigation |
|------|------------|
| SQL injection | Prepared statements |
| Weak passwords | `password_hash` (bcrypt) |
| Unauthorized access | Role checks on routes |
| CSRF | Tokens on POST forms |
| XSS | Output escaping |

---

## Slide 6 — AI feature (responsible use)

- **Intentionally low-risk** — local rule-based logic, no OpenAI API  
- Description assistant suggests draft copy only  
- **Not auto-saved** — admin must review and edit  
- Key line: **AI-generated content requires human review before publishing**  
- AI suggestion log for governance  

---

## Slide 7 — Testing

- 14+ test cases (positive and negative)  
- Examples: invalid login, empty form, user blocked from admin, empty cart  
- Screenshots in `docs/screenshots/`  
- Empty-state messages for reliability  

---

## Slide 8 — Demo & conclusion

**Live demo path:**  
1. User login → browse → add to cart → checkout  
2. Admin login → edit product → AI description → save  
3. Help assistant → activity log  

**Conclusion:** MVP meets brief; known limitations documented; future: payment gateway, email notifications.

---

## Speaker notes (timing)

| Segment | Time | Speaker |
|---------|------|---------|
| Intro + problem | 2 min | Team Lead |
| Features + architecture | 2 min | Back-End |
| Security + AI | 2 min | Front-End / QA |
| Testing + demo | 4–6 min | All (rotate) |
