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
            $categoryId = $this->filterInt($_POST['category_id'] ?? null);
            $photoUrl1 = $this->filterString($_POST['photo_url1'] ?? '');
            $photoUrl2 = $this->filterString($_POST['photo_url2'] ?? '');

            // Generate SKU if not provided
            if (empty($sku)) {
                $sku = $this->generateSku($categoryId);
            }

            if ($name && $sku && $unitPrice > 0) {
                // Save product to the database
                $product = new productsModel();
                $product->setName($name);
                $product->setSku($sku);
                $product->setDescription($description);
                $product->setQuantity($quantity);
                $product->setUnitPrice($unitPrice);
                $product->setCategoryId($categoryId);

                if ($product->save()) {
                    $productId = $product->getProductId(); // Retrieve the newly created product ID

                    // Save photo URLs if provided
                    if (!empty($photoUrl1)) {
                        $this->savePhoto($productId, $photoUrl1);
                    }
                    if (!empty($photoUrl2)) {
                        $this->savePhoto($productId, $photoUrl2);
                    }

                    $this->alertHandler->redirectWithMessage('/products/manageProducts', 'success', 'Product added successfully.');
                } else {
                    $this->alertHandler->redirectWithMessage('/products/add', 'error', 'Failed to add product.');
                }
            } else {
                $this->alertHandler->redirectWithMessage('/products/add', 'error', 'Invalid input. Please fill in all required fields.');
            }
        }

        // Fetch categories for dropdown
        $categories = categoriesModel::getAll();
        $this->_data['categories'] = $categories;

        // Pre-select category if `category_id` is provided in the request
        $currentCategoryId = $this->filterInt($_GET['category_id'] ?? null);
        $this->_data['currentCategoryId'] = $currentCategoryId;

        $this->_view();
    }

    // Helper function to save a photo
    private function savePhoto($productId, $photoUrl)
    {
        $photoModel = new productPhotosModel();
        $photoModel->setProductId($productId);
        $photoModel->setPhotoUrl($photoUrl);
        $photoModel->save();
    }


    // Helper function to generate SKU
    private function generateSku($categoryId)
    {
        // Example SKU generation: "CAT-{CategoryID}-{Random}"
        $categoryPrefix = $categoryId ? 'CAT-' . $categoryId : 'GEN';
        $uniqueId = strtoupper(substr(uniqid(), -5)); // Generate a 5-character unique ID
        return "{$categoryPrefix}-{$uniqueId}";
    }
}
