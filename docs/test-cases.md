# Test Evidence — Assessment 3

Minimum **10 test cases** with positive and negative scenarios. Screenshots in `docs/screenshots/`.

| ID | Type | Test | Steps | Expected result | Actual result | Screenshot |
|----|------|------|-------|-----------------|---------------|------------|
| TC01 | Positive | Admin login | Login as admin@shop.demo / Admin123! | Redirect to catalogue; Admin menu visible | **Pass** — Welcome message; Admin menu shown | `03-catalogue-admin.png` |
| TC02 | Positive | User session | Login as user@shop.demo | Catalogue; Cart and Orders visible | **Pass** — Demo Customer logged in | `03-catalogue-user.png` |
| TC03 | Negative | Invalid login input | Submit login with invalid email format | Client validation error on form | **Pass** — Red validation on email/password | `12-validation-error.png` |
| TC04 | Positive | Product catalogue | View catalogue after login | Products listed with price and stock | **Pass** — 8 products with images | `03-catalogue.png` |
| TC05 | Positive | Product search/filter | _(Recommended — add `05-search-filter.png`)_ | Filtered list | Not captured | — |
| TC06 | Positive | Pagination | _(Recommended — add `06-pagination.png`)_ | Page 2 loads | Not captured | — |
| TC07 | Positive | Cart & checkout | Add items; place order | Order created | **Pass** — Cart total correct; Order #4 success | `07-cart.png`, `08-order-success.png` |
| TC08 | Negative | Empty cart checkout | Checkout with empty cart | Error; no order | Not captured | — |
| TC09 | Positive | Order detail | View placed order | Order line items and total shown | **Pass** — Order #4 pending, $32.50 | `08-order-success.png` |
| TC10 | Negative | User → admin page | User opens admin product URL | Access denied | Not captured | — |
| TC11 | Positive | Help assistant | Ask "how do i place an order" | FAQ answer displayed | **Pass** — Answer from faq source | `10-help-assistant.png` |
| TC12 | Positive | AI description | Admin edit product; AI section visible | Draft assistant + disclaimer | **Pass** — Review required badge; generate button | `09-ai-description.png`, `11-ai-suggestion-log.png` |
| TC13 | Negative | Form validation | Invalid login fields | Validation shown | **Pass** — Same as TC03 | `12-validation-error.png` |
| TC14 | Positive | Product CRUD | Admin edits product with image | Form saves product data | **Pass** — Edit product with image upload | `04-product-crud.png` |
| TC15 | Positive | Activity log | Admin views activity log | Login and actions listed | **Pass** — login, update, order entries | `11-activity-log.png` |
| TC16 | Positive | Help fallback | Ask unknown question (e.g. discount) | Fallback message | **Pass** — Suggests topics; source fallback | `10-help-assistant-fallback.png` |

## Summary

| Result | Count |
|--------|-------|
| Pass (with screenshot) | 12 |
| Pass (not screenshot) | 0 |
| Not captured | 4 |

## Evidence index (files on disk)

- [x] `01-login.png`
- [ ] `02-register.png` — add before final submit
- [x] `03-catalogue.png`
- [x] `03-catalogue-admin.png`
- [x] `03-catalogue-user.png`
- [x] `04-product-crud.png`
- [ ] `05-search-filter.png`
- [ ] `06-pagination.png`
- [x] `07-cart.png`
- [x] `08-order-success.png`
- [x] `09-ai-description.png`
- [x] `10-help-assistant.png`
- [x] `10-help-assistant-fallback.png`
- [x] `11-activity-log.png`
- [x] `11-ai-suggestion-log.png`
- [x] `12-validation-error.png`
- [ ] `13-access-denied.png`
- [ ] `14-mobile-responsive.png`
