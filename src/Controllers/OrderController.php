<?php

declare(strict_types=1);

namespace App\Controllers;

use App\ActivityLogger;
use App\Auth;
use App\Models\OrderModel;
use App\Validator;

final class OrderController
{
    public function index(): void
    {
        Auth::requireLogin();
        $orders = OrderModel::forUser(Auth::id() ?? 0, Auth::isAdmin());
        view('orders.index', [
            'title' => Auth::isAdmin() ? 'All orders' : 'My orders',
            'orders' => $orders,
        ]);
    }

    public function show(): void
    {
        Auth::requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        $order = OrderModel::find($id, Auth::id(), Auth::isAdmin());
        if (!$order) {
            flash('error', 'Order not found.');
            redirect(url('orders.index'));
        }
        view('orders.show', ['title' => 'Order #' . $id, 'order' => $order]);
    }

    public function checkout(): void
    {
        Auth::requireLogin();
        if (!verify_csrf()) {
            redirect(url('cart.index'));
        }
        $cart = $_SESSION['cart'] ?? [];
        if ($cart === []) {
            flash('error', 'Your cart is empty.');
            redirect(url('cart.index'));
        }
        $notes = trim($_POST['notes'] ?? '');
        try {
            $orderId = OrderModel::create(Auth::id() ?? 0, $cart, $notes ?: null, Auth::id() ?? 0);
            $_SESSION['cart'] = [];
            ActivityLogger::log('create', 'order', $orderId, 'Checkout');
            flash('success', 'Order #' . $orderId . ' placed successfully.');
            redirect(url('orders.show', ['id' => $orderId]));
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
            redirect(url('cart.index'));
        }
    }

    public function updateStatus(): void
    {
        Auth::requireAdmin();
        if (!verify_csrf()) {
            redirect(url('orders.index'));
        }
        $id = (int) ($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $v = new Validator(['status' => $status]);
        $v->inList('status', $allowed, 'status');
        if ($v->fails()) {
            flash('error', 'Invalid status.');
            redirect(url('orders.show', ['id' => $id]));
        }
        OrderModel::updateStatus($id, $status, Auth::id() ?? 0);
        ActivityLogger::log('status_update', 'order', $id, $status);
        flash('success', 'Order status updated.');
        redirect(url('orders.show', ['id' => $id]));
    }
}
