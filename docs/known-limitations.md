# Known Limitations

This section documents intentional scope boundaries for the assessment build. These are not bugs; they reflect realistic constraints for a small retail MVP.

- **Payment processing** is simulated. Checkout creates an order record only; there is no connection to a real payment gateway (e.g. Stripe, PayPal).
- **AI description generation** is rule-based and local. It does not call external AI APIs (OpenAI, etc.). Output quality is limited to templates and keyword rules.
- **Product images** support admin upload (JPG/PNG/WebP/GIF, max 2 MB) or an external URL. There is no image resizing CDN or virus scanning beyond MIME checks.
- **Email confirmation** is not implemented (no order confirmation or password-reset emails).
- **Inventory** is basic stock decrement on checkout; no supplier integration or multi-warehouse logic.
- **Delivery tracking** is limited to order status fields (pending → delivered), not carrier APIs.

## Out of scope (not planned for this submission)

To keep the project maintainable and aligned with the brief:

- Real payment gateway integration
- External LLM / OpenAI API calls
- React or full SPA rewrite
- Complex delivery tracking
- Live chat support
