USE retail_shop;

INSERT INTO categories (name) VALUES
  ('Homewares'),
  ('Gifts'),
  ('Stationery'),
  ('Accessories');

-- Run public/setup.php via browser to create users with correct password hashes.
-- Demo passwords: Admin123! (admin) and User123! (user)

INSERT INTO products (category_id, name, sku, description, price, stock, image_url, created_by, updated_by) VALUES
  (1, 'Ceramic Mug Set', 'HW-MUG-001', 'Set of 4 stoneware mugs in neutral tones. Dishwasher safe.', 34.99, 25, NULL, 1, 1),
  (1, 'Linen Table Runner', 'HW-LIN-002', 'Natural linen runner, 180cm. Machine washable.', 29.50, 15, NULL, 1, 1),
  (2, 'Scented Candle Gift Box', 'GF-CAN-010', 'Three soy candles: lavender, cedar, citrus. 40hr burn each.', 45.00, 30, NULL, 1, 1),
  (2, 'Artisan Chocolate Tin', 'GF-CHO-011', 'Assorted dark and milk chocolates. 200g.', 18.75, 40, NULL, 1, 1),
  (3, 'Leather Journal A5', 'ST-JRN-020', 'Hand-stitched cover, 192 lined pages, ribbon bookmark.', 24.00, 20, NULL, 1, 1),
  (3, 'Fountain Pen', 'ST-PEN-021', 'Stainless steel nib, includes converter and ink cartridge.', 32.50, 12, NULL, 1, 1),
  (4, 'Canvas Tote Bag', 'AC-TOT-030', 'Heavy cotton tote with internal pocket. Natural colour.', 16.99, 50, NULL, 1, 1),
  (4, 'Wool Beanie', 'AC-BEA-031', 'Merino blend beanie, one size. Charcoal or cream.', 22.00, 18, NULL, 1, 1);

INSERT INTO orders (user_id, status, total, notes, created_by, updated_by) VALUES
  (2, 'delivered', 59.49, 'Leave at reception if not home', 2, 1),
  (2, 'processing', 45.00, NULL, 2, 1);

INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES
  (1, 1, 1, 34.99),
  (1, 7, 1, 16.99),
  (1, 4, 1, 18.75),
  (2, 3, 1, 45.00);

UPDATE orders SET total = (
  SELECT COALESCE(SUM(quantity * unit_price), 0) FROM order_items WHERE order_id = orders.id
);
