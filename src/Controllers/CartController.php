<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Models\ProductModel;

final class CartController
{
    private function &cart(): array
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        return $_SESSION['cart'];
    }

    public function index(): void
    {
        Auth::requireLogin();
        $items = [];
        $total = 0.0;
        foreach ($this->cart() as $productId => $qty) {
            $p = ProductModel::find((int) $productId);
            if ($p) {
                $line = (float) $p['price'] * $qty;
                $items[] = ['product' => $p, 'quantity' => $qty, 'line_total' => $line];
                $total += $line;
            }
        }
        view('cart.index', ['title' => 'Shopping cart', 'items' => $items, 'total' => $total]);
    }

    public function add(): void
    {
        Auth::requireLogin();
        if (!verify_csrf()) {
            flash('error', 'Invalid session.');
            redirect(url('products.index'));
        }
        $id = (int) ($_POST['product_id'] ?? 0);
        $qty = max(1, (int) ($_POST['quantity'] ?? 1));
        $product = ProductModel::find($id);
        if (!$product) {
            flash('error', 'Product not found.');
            redirect(url('products.index'));
        }
        if ((int) $product['stock'] < $qty) {
            flash('error', 'Not enough stock available.');
            redirect(url('products.show', ['id' => $id]));
        }
        $cart = &$this->cart();
        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        flash('success', 'Added to cart.');
        redirect(url('cart.index'));
    }

    public function update(): void
    {
        Auth::requireLogin();
        if (!verify_csrf()) {
            redirect(url('cart.index'));
        }
        $cart = &$this->cart();
        foreach ($_POST['qty'] ?? [] as $pid => $qty) {
            $qty = (int) $qty;
            if ($qty <= 0) {
                unset($cart[$pid]);
            } else {
                $cart[$pid] = $qty;
            }
        }
        flash('success', 'Cart updated.');
        redirect(url('cart.index'));
    }

    public function clear(): void
    {
        Auth::requireLogin();
        $_SESSION['cart'] = [];
        flash('success', 'Cart cleared.');
        redirect(url('cart.index'));
    }
}
