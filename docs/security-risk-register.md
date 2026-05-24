# Security & Risk Register

| # | Risk | Impact | Likelihood | Mitigation |
|---|------|--------|------------|------------|
| 1 | SQL injection | High | Medium | PDO prepared statements; no string concatenation of user input in SQL |
| 2 | Broken access control | High | Medium | `Auth::requireAdmin()` on admin routes; order views scoped to owner unless admin |
| 3 | Weak passwords | Medium | Medium | Minimum 8 characters; `password_hash` / bcrypt; server-side validation |
| 4 | CSRF on state-changing actions | Medium | Medium | CSRF token on all POST forms; `verify_csrf()` |
| 5 | XSS in user-visible output | Medium | Medium | `htmlspecialchars` via `e()` on all dynamic output |
| 6 | AI hallucination / wrong product copy | Medium | Low | Human must edit description before save; disclaimer shown; `ai_suggestion_log` |
| 7 | PII sent to external AI | High | Low | No external LLM calls; FAQ and templates are local |
| 8 | Session hijacking | Medium | Low | `session_regenerate_id` on login; httponly cookies (PHP defaults) |

## AI-specific risks

- **Over-reliance on AI text:** Mitigated by mandatory review and editable textarea.
- **Logging sensitive notes:** Draft notes should describe products only, not customers.
