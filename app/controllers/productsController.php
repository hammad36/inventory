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
                $this->redirectWithAlert('error', '/categories', "No category selected.");
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
                $product->setCategoryId($categoryId);

                if ($product->save()) {
                    $productId = $product->getProductId();

                    // Save photo URLs
                    $photoUrl1 = $this->filterString($_POST['photo_url1'] ?? '');
                    $photoUrl2 = $this->filterString($_POST['photo_url2'] ?? '');
                    if (!empty($photoUrl1)) $this->savePhoto($productId, $photoUrl1);
                    if (!empty($photoUrl2)) $this->savePhoto($productId, $photoUrl2);

                    $this->redirectWithAlert('success', '/products/manageProducts', "Product added successfully.");
                } else {
                    $this->redirectWithAlert('error', '/products/add', "Failed to add product.");
                }
            } else {
                $this->redirectWithAlert('error', '/products/add', "Invalid input. Please fill in all required fields.");
            }
        }

        $currentCategoryId = $this->filterInt($_GET['category_id'] ?? null);
        $this->_data['currentCategoryId'] = $currentCategoryId;

        $this->_view();
    }

    // Save photo URL
    private function savePhoto($productId, $photoUrl)
    {
        $photoModel = new productPhotosModel();
        $photoModel->setProductId($productId);
        $photoModel->setPhotoUrl($photoUrl);
        $photoModel->save();
    }

    // Generate SKU
    private function generateSku($categoryId)
    {
        $categoryPrefix = $categoryId ? 'CAT-' . $categoryId : 'GEN';
        $uniqueId = strtoupper(substr(uniqid(), -5));
        return "{$categoryPrefix}-{$uniqueId}";
    }

    public function editAction()
    {
        $productId = $this->filterInt($_GET['id'] ?? null);

        if (!$productId) {
            $this->redirectWithAlert('error', '/products', "Invalid product ID.");
            return;
        }

        $product = productsModel::getByPK($productId);

        if (!$product) {
            $this->redirectWithAlert('error', '/products', "Product not found.");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input
            $name = $this->filterString($_POST['name'] ?? '');
            $sku = $this->filterString($_POST['sku'] ?? '');
            $description = $this->filterString($_POST['description'] ?? '');
            $quantity = $this->filterInt($_POST['quantity'] ?? 0);
            $unitPrice = $this->filterFloat($_POST['unit_price'] ?? 0.0);
            $categoryId = $this->filterInt($_POST['category_id'] ?? $_GET['category_id'] ?? null);

            if ($name && $sku && $unitPrice > 0 && $categoryId) {
                // Update product properties
                $product->setName($name);
                $product->setSku($sku);
                $product->setDescription($description);
                $product->setQuantity($quantity);
                $product->setUnitPrice($unitPrice);
                $product->setCategoryId($categoryId);

                if ($product->save()) {
                    $this->updatePhotos($productId);
                    $this->redirectWithAlert('success', '/products/manageProducts', "Product updated successfully.");
                } else {
                    $this->redirectWithAlert('error', '/products/edit?id=' . $productId, "Failed to update product.");
                }
            } else {
                $this->redirectWithAlert('error', '/products/edit?id=' . $productId, "Invalid input. Please fill in all required fields.");
            }
        }

        $this->_data['product'] = $product;
        $this->_data['currentCategoryId'] = $product->getCategoryId();

        $this->_view();
    }
    private function updatePhotos($productId)
    {
        // Delete old photos
        $oldPhotos = productPhotosModel::getByCategoryId($productId);
        foreach ($oldPhotos as $oldPhoto) {
            @unlink($oldPhoto['photo_url']); // Delete file if exists
            $photoModel = productPhotosModel::getByPK($oldPhoto['photo_id']);
            $photoModel->delete(); // Remove record from database
        }

        // Add new photos
        $photoUrl1 = $this->filterString($_POST['photo_url1'] ?? '');
        $photoUrl2 = $this->filterString($_POST['photo_url2'] ?? '');
        if (!empty($photoUrl1)) $this->savePhoto($productId, $photoUrl1);
        if (!empty($photoUrl2)) $this->savePhoto($productId, $photoUrl2);
    }


    // Redirect with alert
    private function redirectWithAlert(string $alertType, string $url, string $message)
    {
        $this->alertHandler->redirectWithMessage($url, $alertType, $message);
    }
}
