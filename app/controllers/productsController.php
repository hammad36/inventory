<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\productsModel;
use inventory\models\productPhotosModel;
use inventory\models\categoriesModel;

class productsController extends abstractController
{
    use InputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        $categoryId = $this->filterInt($_GET['category_id'] ?? null);
        $category = $categoryId ? categoriesModel::getByPK($categoryId) : null;
        $products = $this->getProducts($categoryId);

        $this->renderProductsView($products, $category);
    }

    private function getProducts($categoryId)
    {
        $products = $categoryId
            ? productPhotosModel::getByCategoryId($categoryId)
            : productsModel::getAll();

        foreach ($products as &$product) {
            $product['photo_urls'] = isset($product['photo_urls']) ? explode(',', $product['photo_urls']) : [];
        }

        return $products;
    }

    private function renderProductsView(array $products, $category = null)
    {
        $categories = categoriesModel::getAll();
        $this->_data = [
            'products' => $products,
            'categories' => $categories,
            'category' => $category,
        ];
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input
            $name = $this->filterString($_POST['name'] ?? '');
            $sku = $this->filterString($_POST['sku'] ?? '');
            $description = $this->filterString($_POST['description'] ?? '');
            $quantity = $this->filterInt($_POST['quantity'] ?? 0);
            $unitPrice = $this->filterFloat($_POST['unit_price'] ?? 0.0);

            $categoryId = $this->filterInt($_POST['category_id'] ?? $_GET['category_id'] ?? null);

            if (!$categoryId) {
                $this->redirectWithAlert('error', '', "No category selected.");
                return;
            }

            // Generate SKU if not provided
            if (empty($sku)) {
                $sku = $this->generateSku($categoryId);
            }

            if ($name && $sku && $unitPrice > 0 && $categoryId) {
                $product = new productsModel();
                $product->setName($name);
                $product->setSku($sku);
                $product->setDescription($description);
                $product->setQuantity($quantity);
                $product->setUnitPrice($unitPrice);
                $product->setCategoryID($categoryId);

                if ($product->save()) {
                    $productId = $product->getProductId();

                    // Save photo URLs in batch
                    $photoUrls = array_filter([
                        $this->filterString($_POST['photo_url1'] ?? ''),
                        $this->filterString($_POST['photo_url2'] ?? '')
                    ]);

                    if (!empty($photoUrls)) {
                        productPhotosModel::addPhotosToProduct($productId, $photoUrls);
                    }

                    $this->redirectWithAlert('add', '/products?category_id=' . "$categoryId", "Product added successfully.");
                } else {
                    $this->redirectWithAlert('error', '', "Failed to add product.");
                }
            } else {
                $this->redirectWithAlert('error', '', "Invalid input. Please fill in all required fields.");
            }
        }

        $currentCategoryId = $this->filterInt($_GET['category_id'] ?? null);
        $this->_data['currentCategoryId'] = $currentCategoryId;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }

    public function editAction()
    {
        $productId = $this->filterInt($_GET['id'] ?? null);

        if (!$productId) {
            $this->redirectWithAlert('error', '', "Invalid product ID.");
            return;
        }

        $product = productsModel::getByPK($productId);

        if (!$product) {
            $this->redirectWithAlert('error', '', "Product not found.");
            return;
        }

        $currentCategoryId = $this->filterInt($_GET['category_id'] ?? $product->getCategoryID());
        $productPhotos = productPhotosModel::getPhotosByProductId($productId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->filterString($_POST['name'] ?? '');
            $sku = $this->filterString($_POST['sku'] ?? '');
            $description = $this->filterString($_POST['description'] ?? '');
            $quantity = $this->filterInt($_POST['quantity'] ?? 0);
            $unitPrice = $this->filterFloat($_POST['unit_price'] ?? 0.0);

            if ($name && $sku && $unitPrice > 0) {
                $product->setName($name);
                $product->setSku($sku);
                $product->setDescription($description);
                $product->setQuantity($quantity);
                $product->setUnitPrice($unitPrice);
                $product->setCategoryID($currentCategoryId);

                if ($product->save()) {
                    $newPhotos = array_filter([$_POST['photo_url1'], $_POST['photo_url2']]);
                    productPhotosModel::handlePhotoTransaction(function () use ($productId, $newPhotos) {
                        productPhotosModel::deletePhotosByProductId($productId);
                        return productPhotosModel::addPhotosToProduct($productId, $newPhotos);
                    });

                    $this->redirectWithAlert('success', '/products?category_id=' . $currentCategoryId, "Product updated successfully.");
                } else {
                    $this->redirectWithAlert('error', '', "Failed to update product.");
                }
            } else {
                $this->redirectWithAlert('error', '', "Invalid input. Please fill in all required fields.");
            }
        }

        $this->_data = [
            'product' => $product,
            'photos' => $productPhotos,
            'currentCategoryId' => $currentCategoryId,
        ];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }



    private function updatePhotos($productId)
    {
        // Delete old photos using the model's method
        productPhotosModel::deletePhotosByProductId($productId);

        // Add new photos using the new method
        $photoUrls = array_filter([
            $this->filterString($_POST['photo_url1'] ?? ''),
            $this->filterString($_POST['photo_url2'] ?? '')
        ]);

        if (!empty($photoUrls)) {
            productPhotosModel::addPhotosToProduct($productId, $photoUrls);
        }
    }


    public function deleteAction()
    {
        $productId = $this->filterInt($_GET['id'] ?? null);

        if (!$productId) {
            $this->redirectWithAlert('error', '', 'Invalid product ID.');
            return;
        }

        $product = productsModel::getByPK($productId);

        if (!$product) {
            $this->redirectWithAlert('error', '', 'Product not found.');
            return;
        }

        $categoryId = $product->getCategoryID(); // Retrieve the category ID for redirection.

        if ($product->deleteWithPhotos()) {
            $redirectUrl = '/products' . ($categoryId ? '?category_id=' . $categoryId : '');
            $this->redirectWithAlert('remove', $redirectUrl, 'Product and associated photos deleted successfully.');
        } else {
            $this->redirectWithAlert('error', '', 'Failed to delete product or associated photos.');
        }
    }



    private function generateSku($categoryId)
    {
        $categoryPrefix = $categoryId ? 'CAT-' . $categoryId : 'GEN';
        $uniqueId = strtoupper(substr(uniqid(), -5));
        return "{$categoryPrefix}-{$uniqueId}";
    }
    // Redirect with alert
    private function redirectWithAlert(string $alertType, string $url, string $message)
    {
        $this->alertHandler->redirectWithAlert($url, $alertType, $message);
    }
}
