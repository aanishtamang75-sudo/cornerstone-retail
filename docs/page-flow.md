# Page Flow — Cornerstone Retail

```mermaid
flowchart TD
    Start([Visitor]) --> Login{Logged in?}
    Login -->|No| AuthPage[Login / Register]
    AuthPage --> Catalogue
    Login -->|Yes| Catalogue[Product Catalogue]
    Catalogue --> Search[Search / Filter / Paginate]
    Catalogue --> Detail[Product Detail]
    Detail --> Cart[Shopping Cart]
    Cart --> Checkout[Place Order]
    Checkout --> MyOrders[My Orders]
    Catalogue --> Help[Help Assistant]
    Catalogue --> AdminMenu{Admin?}
    AdminMenu -->|Yes| ProdCRUD[Product CRUD]
    AdminMenu -->|Yes| AllOrders[All Orders + Status]
    AdminMenu -->|Yes| Activity[Activity Log]
    AdminMenu -->|Yes| AiLog[AI Suggestion Log]
    ProdCRUD --> AiDraft[AI Description Draft]
    AiDraft -->|Human edits| ProdCRUD
```

## Page list

| Page | Route | Access |
|------|-------|--------|
| Login | `login` | Guest |
| Register | `register` | Guest |
| Catalogue | `products.index` | All |
| Product detail | `products.show` | All |
| Add / edit product | `products.create`, `products.edit` | Admin |
| Cart | `cart.index` | User |
| Orders list | `orders.index` | User (own) / Admin (all) |
| Order detail | `orders.show` | Owner / Admin |
| Help | `help.index` | All |
| Activity log | `admin.activity` | Admin |
| AI log | `admin.aiLog` | Admin |
