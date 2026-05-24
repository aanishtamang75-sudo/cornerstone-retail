# Test Evidence — Assessment 3

Minimum **10 test cases** with positive and negative scenarios. Screenshots in `docs/screenshots/`.

| ID | Type | Test | Steps | Expected result | Actual result | Screenshot |
|----|------|------|-------|-----------------|---------------|------------|
| TC01 | Positive | Admin login | Login as admin@shop.demo / Admin123! | Redirect to catalogue; Admin menu visible | **Pass** | `03-catalogue-admin.png` |
| TC02 | Positive | User session | Login as user@shop.demo | Catalogue; Cart and Orders visible | **Pass** | `03-catalogue-user.png` |
| TC03 | Negative | Invalid login input | Submit login with invalid email format | Client validation error | **Pass** | `12-validation-error.png` |
| TC04 | Positive | Product catalogue | View catalogue after login | Products listed with price and stock | **Pass** | `03-catalogue.png` |
| TC05 | Positive | Filter by category | Filter Category = Stationery | Only stationery products shown | **Pass** — 2 products found | `05-search-filter.png` |
| TC06 | Positive | Pagination | Open catalogue page 2 | Page 2 loads with products | **Pass** — URL `page=2`; products listed | `06-pagination.png` |
| TC07 | Positive | Cart & checkout | Add items; place order | Order created | **Pass** | `07-cart.png`, `08-order-success.png` |
| TC08 | Negative | Empty cart checkout | Checkout with empty cart | Error; no order | Not captured | — |
| TC09 | Positive | Order detail | View placed order | Order line items and total shown | **Pass** | `08-order-success.png` |
| TC10 | Negative | User → admin page | User opens admin product URL | Access denied | Not captured | — |
| TC11 | Positive | Help assistant | Ask "how do i place an order" | FAQ answer displayed | **Pass** | `10-help-assistant.png` |
| TC12 | Positive | AI description | Admin edit product; AI section | Draft assistant + disclaimer | **Pass** | `09-ai-description.png`, `11-ai-suggestion-log.png` |
| TC13 | Negative | Form validation | Invalid login fields | Validation shown | **Pass** | `12-validation-error.png` |
| TC14 | Positive | Product CRUD | Admin edits product with image | Form saves product data | **Pass** | `04-product-crud.png` |
| TC15 | Positive | Activity log | Admin views activity log | Actions listed | **Pass** | `11-activity-log.png` |
| TC16 | Positive | Responsive UI | Mobile width (400px) | Layout usable; nav collapses | **Pass** | `14-mobile-responsive.png` |

## Summary

| Result | Count |
|--------|-------|
| Pass (with screenshot) | 15 |
| Not captured | 2 |

## Evidence index

- [x] `01-login.png`
- [ ] `02-register.png`
- [x] `03-catalogue.png` / admin / user variants
- [x] `04-product-crud.png`
- [x] `05-search-filter.png`
- [x] `06-pagination.png`
- [x] `07-cart.png`
- [x] `08-order-success.png`
- [x] `09-ai-description.png`
- [x] `10-help-assistant.png` (+ fallback)
- [x] `11-activity-log.png` / `11-ai-suggestion-log.png`
- [x] `12-validation-error.png`
- [ ] `13-access-denied.png`
- [x] `14-mobile-responsive.png` (+ admin/user menu variants)
