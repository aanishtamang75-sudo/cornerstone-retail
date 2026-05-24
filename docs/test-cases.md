# Test Evidence — Assessment 3

Minimum **10 test cases** with positive and negative scenarios. Add screenshots to `docs/screenshots/`.

| ID | Type | Test | Steps | Expected result | Actual result | Screenshot |
|----|------|------|-------|-----------------|---------------|------------|
| TC01 | Positive | Admin login | Login as admin@shop.demo / Admin123! | Redirect to catalogue; Admin menu visible | _Pass — fill after test_ | 01-login.png |
| TC02 | Positive | User registration | Register with valid name, email, password | Account created; logged in | _Pass_ | 02-register.png |
| TC03 | Negative | Invalid login | Correct email, wrong password | Error message; stay on login | _Pass_ | 12-validation-error.png |
| TC04 | Positive | Product search | Search "mug" on catalogue | Matching products listed | _Pass_ | 05-search-filter.png |
| TC05 | Positive | Filter by category | Select Homewares | Only homeware products | _Pass_ | 05-search-filter.png |
| TC06 | Positive | Pagination | Open page 2 when >6 products | Page 2 loads correctly | _Pass_ | 06-pagination.png |
| TC07 | Positive | Checkout | User adds items, places order | Order created; stock reduced | _Pass_ | 07-cart-checkout.png |
| TC08 | Negative | Empty cart checkout | Cart empty; try checkout | Error: cart empty; no order | _Pass_ | 12-validation-error.png |
| TC09 | Positive | Admin order status | Admin sets order to Shipped | Status saved; activity logged | _Pass_ | 08-orders.png |
| TC10 | Negative | User → admin page | user@shop.demo opens products.create | Access denied / redirect | _Pass_ | 13-access-denied.png |
| TC11 | Positive | Help assistant | Ask "How do I place an order?" | FAQ answer displayed | _Pass_ | 10-help-assistant.png |
| TC12 | Positive | AI description | Admin generates draft, edits, saves | Product saved; AI log entry | _Pass_ | 09-ai-description.png |
| TC13 | Negative | Empty product form | Submit add product with blank fields | Validation error; not saved | _Pass_ | 12-validation-error.png |
| TC14 | Positive | Product CRUD | Admin creates product with image | Product appears in catalogue | _Pass_ | 04-product-crud.png |
| TC15 | Positive | Activity log | Admin views activity after login | Login/actions listed | _Pass_ | 11-activity-log.png |
| TC16 | Positive | Responsive UI | Resize to mobile width | Layout usable; nav collapses | _Pass_ | 14-mobile-responsive.png |

## Summary

| Result | Count |
|--------|-------|
| Pass | _16_ |
| Fail | _0_ |

_Update Actual result column after your final test run._

## Negative testing focus

| Test | Expected | Actual |
|------|----------|--------|
| Invalid login | Error message | |
| Empty product name | Validation shown | |
| User opens admin page | Access denied | |
| Empty cart checkout | Error; no order | |
