<?php

declare(strict_types=1);

namespace App\Controllers;

use App\ActivityLogger;
use App\Auth;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Services\ImageUploadService;
use App\Validator;

final class ProductController
{
    public function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'category_id' => $_GET['category_id'] ?? '',
            'min_price' => $_GET['min_price'] ?? '',
            'max_price' => $_GET['max_price'] ?? '',
            'in_stock' => $_GET['in_stock'] ?? '',
        ];
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = ProductModel::paginated($filters, $page, (int) app_config('per_page', 6));
        view('products.index', [
            'title' => 'Product catalogue',
            'products' => $result,
            'filters' => $filters,
            'categories' => CategoryModel::all(),
        ]);
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $product = ProductModel::find($id);
        if (!$product) {
            http_response_code(404);
            view('errors.404', ['title' => 'Product not found']);
            return;
        }
        view('products.show', ['title' => $product['name'], 'product' => $product]);
    }

    public function createForm(): void
    {
        Auth::requireAdmin();
        view('products.form', [
            'title' => 'Add product',
            'product' => null,
            'categories' => CategoryModel::all(),
            'ai_disclaimer' => app_config('ai_disclaimer'),
        ]);
    }

    public function create(): void
    {
        Auth::requireAdmin();
        $this->saveProduct(null);
    }

    public function editForm(): void
    {
        Auth::requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $product = ProductModel::find($id);
        if (!$product) {
            flash('error', 'Product not found.');
            redirect(url('products.index'));
        }
        view('products.form', [
            'title' => 'Edit product',
            'product' => $product,
            'categories' => CategoryModel::all(),
            'ai_disclaimer' => app_config('ai_disclaimer'),
        ]);
    }

    public function update(): void
    {
        Auth::requireAdmin();
        $id = (int) ($_POST['id'] ?? 0);
        $this->saveProduct($id);
    }

    public function delete(): void
    {
        Auth::requireAdmin();
        if (!verify_csrf()) {
            flash('error', 'Invalid session.');
            redirect(url('products.index'));
        }
        $id = (int) ($_POST['id'] ?? 0);
        $product = ProductModel::find($id);
        if ($product) {
            ImageUploadService::deleteIfLocal($product['image_url'] ?? null);
        }
        ProductModel::delete($id);
        ActivityLogger::log('delete', 'product', $id);
        flash('success', 'Product deleted.');
        redirect(url('products.index'));
    }

    private function saveProduct(?int $id): void
    {
        if (!verify_csrf()) {
            flash('error', 'Invalid session.');
            redirect(url($id ? 'products.edit' : 'products.create', $id ? ['id' => $id] : []));
        }
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'sku' => strtoupper(trim($_POST['sku'] ?? '')),
            'description' => trim($_POST['description'] ?? ''),
            'price' => $_POST['price'] ?? '',
            'stock' => $_POST['stock'] ?? '',
            'category_id' => $_POST['category_id'] ?? '',
            'image_url' => trim($_POST['image_url'] ?? ''),
        ];
        set_old($data);

        $v = new Validator($data);
        $v->required('name', 'Name')->minLen('name', 2, 'Name')
            ->required('sku', 'SKU')->minLen('sku', 3, 'SKU')
            ->required('price', 'Price')->numeric('price', 'Price')
            ->required('stock', 'Stock')->integer('stock', 'Stock');
        if ($v->fails()) {
            flash('error', implode(' ', $v->errors()));
            redirect(url($id ? 'products.edit' : 'products.create', $id ? ['id' => $id] : []));
        }
        if (ProductModel::skuExists($data['sku'], $id)) {
            flash('error', 'SKU already exists.');
            redirect(url($id ? 'products.edit' : 'products.create', $id ? ['id' => $id] : []));
        }

        $existing = $id ? ProductModel::find($id) : null;
        $imageUrl = $this->resolveImageUrl($data['image_url'], $existing);

        $payload = [
            'name' => $data['name'],
            'sku' => $data['sku'],
            'description' => $data['description'],
            'price' => round((float) $data['price'], 2),
            'stock' => (int) $data['stock'],
            'category_id' => $data['category_id'] !== '' ? (int) $data['category_id'] : null,
            'image_url' => $imageUrl ?: null,
        ];
        $userId = Auth::id() ?? 0;

        if ($id) {
            ProductModel::update($id, $payload, $userId);
            ActivityLogger::log('update', 'product', $id, $data['name']);
            flash('success', 'Product updated.');
        } else {
            $newId = ProductModel::create($payload, $userId);
            ActivityLogger::log('create', 'product', $newId, $data['name']);
            flash('success', 'Product created.');
        }
        clear_old();
        redirect(url('products.index'));
    }

    private function resolveImageUrl(string $urlFromForm, ?array $existing): ?string
    {
        $hasUpload = isset($_FILES['image'])
            && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;

        if ($hasUpload) {
            try {
                ImageUploadService::deleteIfLocal($existing['image_url'] ?? null);
                return ImageUploadService::store($_FILES['image']);
            } catch (\InvalidArgumentException $e) {
                flash('error', $e->getMessage());
                redirect(url(
                    $existing ? 'products.edit' : 'products.create',
                    $existing ? ['id' => $existing['id']] : []
                ));
            }
        }

        $urlFromForm = trim($urlFromForm);
        if ($urlFromForm !== '') {
            if ($existing && ($existing['image_url'] ?? '') !== $urlFromForm) {
                ImageUploadService::deleteIfLocal($existing['image_url'] ?? null);
            }
            return $urlFromForm;
        }

        return $existing['image_url'] ?? null;
    }
}
