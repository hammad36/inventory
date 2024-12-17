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

    // Default action: List products
    public function defaultAction()
    {
        $categoryId = $this->filterInt($_GET['category_id'] ?? null);
        $category = $categoryId ? categoriesModel::getByPK($categoryId) : null;
        $products = $this->getProducts($categoryId);

        $this->renderProductsView($products, $category);
    }

    // Add a product
    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = $this->filterInt($_POST['category_id'] ?? $_GET['category_id'] ?? null);

            if (!$categoryId) {
                $this->redirectWithAlert('error', '', "No category selected.");
                return;
            }

            // Validate and save product
            $product = $this->validateAndSaveProduct($categoryId);

            if ($product) {
                // Handle product photos
                $photoUrls = $this->getPhotoUrlsFromPost();
                productPhotosModel::addPhotosToProduct($product->getProductId(), $photoUrls);

                $this->redirectWithAlert('add', "/products?category_id=$categoryId", "Product added successfully.");
            } else {
                $this->redirectWithAlert('error', "/products?category_id=$categoryId", "Failed to add product.");
            }
        }

        $this->_data['currentCategoryId'] = $this->filterInt($_GET['category_id'] ?? null);
        $this->startSessionIfNotStarted();
        $this->_view();
    }

    // Edit a product
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

        // Ensure photos array has at least 2 items
        $photoUrl1 = $productPhotos[0] ?? '';
        $photoUrl2 = $productPhotos[1] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->updateProductDetails($product, $currentCategoryId)) {
                $newPhotos = $this->getPhotoUrlsFromPost();
                $this->updateProductPhotos($productId, $newPhotos);

                $this->redirectWithAlert('success', "/products?category_id=$currentCategoryId", "Product updated successfully.");
            } else {
                $this->redirectWithAlert('error', "/products?category_id=$currentCategoryId", "Failed to update product.");
            }
        }

        $this->_data = compact('product', 'productPhotos', 'currentCategoryId', 'photoUrl1', 'photoUrl2');
        $this->startSessionIfNotStarted();
        $this->_view();
    }

    // Delete a product
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

        $categoryId = $product->getCategoryID();
        $redirectUrl = '/products' . ($categoryId ? "?category_id=$categoryId" : '');

        if ($product->deleteWithPhotos()) {
            $this->redirectWithAlert('remove', $redirectUrl, 'Product and associated photos deleted successfully.');
        } else {
            $this->redirectWithAlert('error', $redirectUrl, 'Failed to delete product or associated photos.');
        }
    }

    // --- Private Utility Methods ---

    // Fetch products with their photos
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

    // Render the products view
    private function renderProductsView(array $products, $category = null)
    {
        $categories = categoriesModel::getAll();
        $this->_data = compact('products', 'categories', 'category');
        $this->startSessionIfNotStarted();
        $this->_view();
    }

    // Validate input and save a product
    private function validateAndSaveProduct($categoryId)
    {
        $productName = $this->filterString($_POST['product_name'] ?? '');
        $sku = $this->filterString($_POST['sku'] ?? $this->generateSku($categoryId));
        $description = $this->filterString($_POST['description'] ?? '');
        $quantity = $this->filterInt($_POST['quantity'] ?? 0);
        $unitPrice = $this->filterFloat($_POST['unit_price'] ?? 0.0);

        if (!$productName || !$sku || $unitPrice <= 0) {
            return false;
        }

        $product = new productsModel();
        $product->setName($productName);
        $product->setSku($sku);
        $product->setDescription($description);
        $product->setQuantity($quantity);
        $product->setUnitPrice($unitPrice);
        $product->setCategoryID($categoryId);

        return $product->save() ? $product : false;
    }

    // Update product details
    private function updateProductDetails($product, $categoryId)
    {
        $productName = $this->filterString($_POST['product_name'] ?? '');
        $sku = $this->filterString($_POST['sku'] ?? '');
        $description = $this->filterString($_POST['description'] ?? '');
        $quantity = $this->filterInt($_POST['quantity'] ?? 0);
        $unitPrice = $this->filterFloat($_POST['unit_price'] ?? 0.0);

        if (!$productName || !$sku || $unitPrice <= 0) {
            return false;
        }

        $product->setName($productName);
        $product->setSku($sku);
        $product->setDescription($description);
        $product->setQuantity($quantity);
        $product->setUnitPrice($unitPrice);
        $product->setCategoryID($categoryId);

        return $product->save();
    }

    // Get photo URLs from POST data
    private function getPhotoUrlsFromPost(): array
    {
        return array_filter([
            $this->filterString($_POST['photo_url1'] ?? ''),
            $this->filterString($_POST['photo_url2'] ?? '')
        ]);
    }

    // Update product photos
    private function updateProductPhotos($productId, array $newPhotos)
    {
        productPhotosModel::handlePhotoTransaction(function () use ($productId, $newPhotos) {
            productPhotosModel::deletePhotosByProductId($productId);
            return productPhotosModel::addPhotosToProduct($productId, $newPhotos);
        });
    }

    // Generate SKU
    private function generateSku($categoryId): string
    {
        $categoryPrefix = $categoryId ? 'CAT-' . $categoryId : 'GEN';
        $uniqueId = strtoupper(substr(uniqid(), -5));
        return "{$categoryPrefix}-{$uniqueId}";
    }

    // Redirect with alert
    private function redirectWithAlert(string $type, string $url, string $message)
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }

    // Start session if not already started
    private function startSessionIfNotStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
