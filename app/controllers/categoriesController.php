<?php

namespace inventory\controllers;

use DateTime;
use inventory\controllers\abstractController;
use inventory\lib\inputFilter;
use inventory\lib\alertHandler;
use inventory\models\cartItemsModel;
use inventory\models\categoriesModel;
use inventory\models\productPhotosModel;
use inventory\models\productsModel;
use inventory\models\stockAdjustmentsModel;

class categoriesController extends abstractController
{
    use inputFilter;

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

    public function addToCartAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Get and validate user
                $userId = $_SESSION['user']['id'] ?? null;
                if (!$userId) {
                    $this->redirectWithAlert('error', '/categories', 'Please log in to add items to cart.');
                    return;
                }

                // Get and validate product data
                $productId = $this->filterInt($_POST['product_id'] ?? null);
                $quantity = $this->filterInt($_POST['quantity'] ?? 1);

                if (!$productId || $quantity <= 0) {
                    $this->redirectWithAlert('error', '/categories', 'Invalid input for adding to cart.');
                    return;
                }

                // Validate product exists
                $product = productsModel::getByPK($productId);
                if (!$product) {
                    $this->redirectWithAlert('error', '/categories', 'Product not found.');
                    return;
                }

                // Check for existing cart item
                $existingItems = cartItemsModel::getBy([
                    'user_id' => $userId,
                    'product_id' => $productId
                ]);

                if (!empty($existingItems)) {
                    // Update existing cart item
                    $cartItem = $existingItems[0];
                    $newQuantity = $cartItem->getQuantity() + $quantity;
                    $cartItem->setQuantity((string)$newQuantity); // Cast to string as required by model
                    $success = $cartItem->save();
                } else {
                    // Create new cart item
                    $cartItem = new cartItemsModel();
                    $cartItem->setUserID((string)$userId); // Cast to string as required by model
                    $cartItem->setProductID((string)$productId); // Cast to string as required by model
                    $cartItem->setQuantity((string)$quantity); // Cast to string as required by model
                    // added_at will be set automatically by model default
                    $success = $cartItem->save();
                }

                if ($success) {
                    $this->redirectWithAlert('success', '/categories', "Product added to cart successfully.");
                } else {
                    $this->redirectWithAlert('error', '/categories', "Failed to add product to cart.");
                }
            } catch (\InvalidArgumentException $e) {
                $this->redirectWithAlert('error', '/categories', $e->getMessage());
            } catch (\Exception $e) {
                $this->redirectWithAlert('error', '/categories', "An error occurred while adding to cart.");
            }
        }
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
