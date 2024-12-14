<?php

namespace inventory\controllers;

use DateTime;
use inventory\controllers\abstractController;
use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\categoriesModel;
use inventory\models\productPhotosModel;
use inventory\models\productsModel;
use inventory\models\stockAdjustmentsModel;

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
        $categoryId = $this->getValidatedCategoryId($categoryId);
        if (!$categoryId) return;

        $category = categoriesModel::getByPK($categoryId);
        if (!$this->validateCategoryExists($category, '/categories')) return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStockAdjustment($categoryId);
        }

        $this->_data = [
            'category' => $category,
            'products' => productPhotosModel::getByCategoryId($categoryId),
            'stockAdjustments' => stockAdjustmentsModel::getByCategoryId($categoryId),
        ];

        $this->ensureSessionStarted();
        $this->_view();
    }

    private function handleStockAdjustment($categoryId)
    {
        $redirectUrl = "/categories/category/" . htmlspecialchars($categoryId);

        [$productId, $adjustmentType, $quantity, $userId] = $this->getStockAdjustmentInputs();
        if (!$this->validateStockAdjustmentInputs($productId, $adjustmentType, $quantity, $redirectUrl)) return;

        $product = productsModel::getByPK($productId);
        if (!$this->validateProductExists($product, $redirectUrl)) return;

        $successMessage = $this->adjustProductStock($product, $adjustmentType, $quantity);
        if (!$successMessage) {
            $this->redirectWithAlert('error', $redirectUrl, "Failed to adjust stock.");
            return;
        }

        if ($this->logStockAdjustment($productId, $userId, $adjustmentType, $quantity)) {
            $this->redirectWithAlert('success', $redirectUrl, $successMessage);
        } else {
            $this->redirectWithAlert('error', $redirectUrl, "Stock updated, but failed to log adjustment.");
        }
    }

    private function adjustProductStock(productsModel $product, $adjustmentType, $quantity)
    {
        $newQuantity = $adjustmentType === 'addition'
            ? $product->getQuantity() + $quantity
            : max(0, $product->getQuantity() - $quantity);

        $product->setQuantity($newQuantity);
        $action = $adjustmentType === 'addition' ? 'added to' : 'reduced from';

        return $product->save()
            ? "Successfully $action {$product->getName()} by $quantity."
            : null;
    }

    private function logStockAdjustment($productId, $userId, $adjustmentType, $quantity)
    {
        $adjustment = new stockAdjustmentsModel();
        $adjustment->setProductId($productId);
        $adjustment->setUserId($userId);
        $adjustment->setChangeType($adjustmentType);
        $adjustment->setQuantityChange($quantity);
        $adjustment->setTimestamp(date('Y-m-d H:i:s'));

        return $adjustment->save();
    }

    public function manageCategoriesAction()
    {
        $this->renderCategoriesView(categoriesModel::getAll());
    }

    public function addNewCategoryAction()
    {
        $this->processCategoryForm(new categoriesModel(), '/categories/manageCategories/AddNewCategory', 'add', 'Category added successfully.');
    }

    public function editCategoryAction($categoryId)
    {
        $category = categoriesModel::getByPK($categoryId);
        if (!$this->validateCategoryExists($category, '/categories/manageCategories')) return;

        $this->processCategoryForm($category, "/categories/editCategory/$categoryId", 'edit', 'Category updated successfully.');
    }

    public function deleteAction($categoryId)
    {
        $category = categoriesModel::getByPK($categoryId);
        if (!$this->validateCategoryExists($category, '/categories/manageCategories')) return;

        $message = $category->delete()
            ? "Category deleted successfully."
            : "Failed to delete category.";

        $this->redirectWithAlert($category->delete() ? 'remove' : 'error', '/categories/manageCategories', $message);
    }

    private function processCategoryForm(categoriesModel $category, string $errorRedirect, string $alertType, string $successMessage)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        } else {
            $this->_data['category'] = $category;
            $this->ensureSessionStarted();
            $this->_view(['user' => $_SESSION['user'] ?? null]);
        }
    }

    private function renderCategoriesView(array $categories)
    {
        $this->_data['categories'] = $categories;
        $this->ensureSessionStarted();
        $this->_view();
    }

    private function redirectWithAlert(string $alertType, string $url, string $message)
    {
        $this->alertHandler->redirectWithAlert($url, $alertType, $message);
    }

    private function getValidatedCategoryId($categoryId)
    {
        return $this->filterInt($categoryId ?? $_GET['category_id'] ?? null);
    }

    private function validateCategoryExists($category, $redirectUrl)
    {
        if (!$category) {
            $this->redirectWithAlert('error', $redirectUrl, "Category not found.");
            return false;
        }
        return true;
    }

    private function validateProductExists($product, $redirectUrl)
    {
        if (!$product) {
            $this->redirectWithAlert('error', $redirectUrl, "Product not found.");
            return false;
        }
        return true;
    }

    private function validateStockAdjustmentInputs($productId, $adjustmentType, $quantity, $redirectUrl)
    {
        if (!$productId || !$adjustmentType || $quantity <= 0) {
            $this->redirectWithAlert('error', $redirectUrl, "Invalid input for stock adjustment.");
            return false;
        }
        return true;
    }

    private function getStockAdjustmentInputs()
    {
        return [
            $this->filterInt($_POST['product_id'] ?? null),
            $_POST['adjustment_type'] ?? null,
            $this->filterInt($_POST['quantity'] ?? 0),
            $_SESSION['user']['id'] ?? null,
        ];
    }

    private function ensureSessionStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
