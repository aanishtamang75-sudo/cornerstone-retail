-- Cornerstone Retail — Full database export for Assessment 3
-- Import: phpMyAdmin → Import → choose this file
-- Or: mysql -u root < database.sql
-- Demo passwords: Admin123! (admin), User123! (user)

CREATE DATABASE IF NOT EXISTS retail_shop
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE retail_shop;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS ai_suggestion_log;
DROP TABLE IF EXISTS activity_log;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(120) NOT NULL,
  role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NULL,
  name VARCHAR(200) NOT NULL,
  sku VARCHAR(50) NOT NULL UNIQUE,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  stock INT NOT NULL DEFAULT 0,
  image_url VARCHAR(500) DEFAULT NULL,
  created_by INT UNSIGNED NULL,
  updated_by INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  CONSTRAINT fk_products_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_products_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_products_name (name),
  INDEX idx_products_category (category_id),
  INDEX idx_products_price (price)
) ENGINE=InnoDB;

CREATE TABLE orders (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
  total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  notes TEXT,
  created_by INT UNSIGNED NULL,
  updated_by INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
  CONSTRAINT fk_orders_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_orders_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_orders_user (user_id),
  INDEX idx_orders_status (status)
) ENGINE=InnoDB;

CREATE TABLE order_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  quantity INT UNSIGNED NOT NULL DEFAULT 1,
  unit_price DECIMAL(10, 2) NOT NULL,
  CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE activity_log (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  action VARCHAR(80) NOT NULL,
  entity_type VARCHAR(40) NOT NULL,
  entity_id INT UNSIGNED NULL,
  details TEXT,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_activity_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_activity_created (created_at)
) ENGINE=InnoDB;

CREATE TABLE ai_suggestion_log (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  feature VARCHAR(60) NOT NULL,
  input_text TEXT,
  suggested_text TEXT,
  accepted_text TEXT,
  was_accepted TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_ai_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Demo data
INSERT INTO categories (name) VALUES
  ('Homewares'), ('Gifts'), ('Stationery'), ('Accessories');

INSERT INTO users (email, password_hash, full_name, role) VALUES
  ('admin@shop.demo', '$2y$10$ZIF7MbOBhbcwRrrwQH8H5e1HzkmXu/auJt3s03NX3tz7aNFrKupE.', 'Shop Admin', 'admin'),
  ('user@shop.demo', '$2y$10$tCGrQuw08NCZEmQo5km0subHSreUZz62lKqSJ8yI07uHkJghgdrF2', 'Demo Customer', 'user');

INSERT INTO products (category_id, name, sku, description, price, stock, created_by, updated_by) VALUES
  (1, 'Ceramic Mug Set', 'HW-MUG-001', 'Set of 4 stoneware mugs in neutral tones. Dishwasher safe.', 34.99, 25, 1, 1),
  (1, 'Linen Table Runner', 'HW-LIN-002', 'Natural linen runner, 180cm. Machine washable.', 29.50, 15, 1, 1),
  (2, 'Scented Candle Gift Box', 'GF-CAN-010', 'Three soy candles: lavender, cedar, citrus.', 45.00, 30, 1, 1),
  (2, 'Artisan Chocolate Tin', 'GF-CHO-011', 'Assorted dark and milk chocolates. 200g.', 18.75, 40, 1, 1),
  (3, 'Leather Journal A5', 'ST-JRN-020', 'Hand-stitched cover, 192 lined pages.', 24.00, 20, 1, 1),
  (3, 'Fountain Pen', 'ST-PEN-021', 'Stainless steel nib with ink cartridge.', 32.50, 12, 1, 1),
  (4, 'Canvas Tote Bag', 'AC-TOT-030', 'Heavy cotton tote with internal pocket.', 16.99, 50, 1, 1),
  (4, 'Wool Beanie', 'AC-BEA-031', 'Merino blend beanie, one size.', 22.00, 18, 1, 1);

INSERT INTO orders (user_id, status, total, notes, created_by, updated_by) VALUES
  (2, 'delivered', 51.98, 'Demo order', 2, 1);

INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES
  (1, 1, 1, 34.99),
  (1, 7, 1, 16.99);
