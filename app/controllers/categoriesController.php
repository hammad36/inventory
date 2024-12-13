<?php

namespace inventory\controllers;

use DateTime;
use inventory\controllers\abstractController;
use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\categoriesModel;
use inventory\models\productPhotosModel;
use inventory\models\productsModel;

class categoriesController extends abstractController
{
    use InputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        $this->renderCategoriesView(categoriesModel::getAll());
    }

    public function categoryAction($categoryId = null)
    {
        // Fallback to query parameter if not provided dynamically
        $categoryId = $categoryId ?? $this->filterInt($_GET['category_id'] ?? null);

        // Redirect if no valid categoryId is found
        if (!$categoryId) {
            $this->redirectWithAlert('error', '/categories', "Category ID is missing.");
            return;
        }

        $category = categoriesModel::getByPK($categoryId);
        if (!$category) {
            $this->redirectWithAlert('error', '/categories', "Category not found.");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStockAdjustment();
        }

        $this->_data = [
            'category' => $category,
            'products' => productPhotosModel::getByCategoryId($categoryId),
        ];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }

    private function handleStockAdjustment()
    {
        // Validate input fields
        $productId = $this->filterInt($_POST['product_id'] ?? null);
        $adjustmentType = $_POST['adjustment_type'] ?? null;
        $quantity = $this->filterInt($_POST['quantity'] ?? 0);

        if (!$productId || !$adjustmentType || $quantity <= 0) {
            $this->redirectWithAlert('error', '', "Invalid input for stock adjustment.");
            return;
        }

        $product = productsModel::getByPK($productId);
        if (!$product) {
            $this->redirectWithAlert('error', '', "Product not found.");
            return;
        }

        // Adjust the stock
        if ($adjustmentType === 'addition') {
            $product->setQuantity($product->getQuantity() + $quantity);
            $successMessage = "Successfully added $quantity to {$product->getName()}";
        } elseif ($adjustmentType === 'reduction') {
            if ($product->getQuantity() < $quantity) {
                $this->redirectWithAlert('error', '', "Insufficient stock to reduce.");
                return;
            }
            $product->setQuantity($product->getQuantity() - $quantity);
            $successMessage = "Successfully reduced $quantity from {$product->getName()}";
        } else {
            $this->redirectWithAlert('error', '', "Invalid adjustment type.");
            return;
        }

        if ($product->save()) {
            $this->redirectWithAlert('success', '', $successMessage);
        } else {
            $this->redirectWithAlert('error', '', "Failed to update stock.");
        }
    }

    public function manageCategoriesAction()
    {
        $this->renderCategoriesView(categoriesModel::getAll());
    }

    public function addNewCategoryAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processCategoryForm(new categoriesModel(), '/categories/manageCategories/AddNewCategory', 'add', 'Category added successfully.');
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->_view([
                'user' => $_SESSION['user'] ?? null
            ]);
        }
    }

    public function editCategoryAction($categoryId)
    {
        $category = categoriesModel::getByPK($categoryId);
        if (!$category) {
            $this->redirectWithAlert('error', '/categories/manageCategories', "Category not found.");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processCategoryForm($category, "/categories/editCategory/$categoryId", 'edit', 'Category updated successfully.');
        } else {
            $this->_data['category'] = $category;
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->_view([
                'user' => $_SESSION['user'] ?? null
            ]);
        }
    }

    public function deleteAction($categoryId)
    {
        $category = categoriesModel::getByPK($categoryId);
        if (!$category) {
            $this->redirectWithAlert('error', '/categories/manageCategories', "Category not found.");
            return;
        }

        if ($category->delete()) {
            $this->redirectWithAlert('remove', '/categories/manageCategories', "Category deleted successfully.");
        } else {
            $this->redirectWithAlert('error', '/categories/manageCategories', "Failed to delete category.");
        }
    }

    private function processCategoryForm(categoriesModel $category, string $errorRedirect, string $alertType, string $successMessage)
    {
        $name = $this->filterString($_POST['name'], 1, 255);
        $description = $this->filterString($_POST['description'], 1, 1000);
        $photoUrl = $this->filterUrl($_POST['photo_url']);

        if (empty($name) || empty($description) || empty($photoUrl)) {
            $this->redirectWithAlert('error', $errorRedirect, "All fields are required.");
            return;
        }

        $category->setName($name);
        $category->setDescription($description);
        $category->setPhotoUrl($photoUrl);

        if ($category->save()) {
            $this->redirectWithAlert($alertType, '/categories/manageCategories', $successMessage);
        } else {
            $this->redirectWithAlert('error', $errorRedirect, "Failed to save category.");
        }
    }

    private function renderCategoriesView(array $categories)
    {
        $this->_data['categories'] = $categories;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->_view();
    }

    public function manageProductsAction()
    {
        $this->renderCategoriesView(categoriesModel::getAll());
    }

    private function redirectWithAlert(string $alertType, string $url, string $message)
    {
        $this->alertHandler->redirectWithAlert($url, $alertType, $message);
    }
}
