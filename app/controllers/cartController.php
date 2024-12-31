<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\alertHandler;
use inventory\lib\inputFilter;
use inventory\models\cartItemsModel;
use inventory\models\productPhotosModel;
use inventory\models\productsModel;

class cartController extends abstractController
{
    use inputFilter;

    private $alertHandler;

    public function __construct()
    {
        $this->alertHandler = alertHandler::getInstance();
    }

    public function defaultAction()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user'])) {
            // Redirect to login page with a message
            $this->redirectWithAlert('warning', '/login', 'Please sign in to view your cart.');
            return;
        }

        // Fetch cart items for the logged-in user
        $userId = $_SESSION['user']['id'];
        $cartItems = cartItemsModel::getBy(['user_id' => $userId]);

        // Fetch product details and photos for each cart item
        $cartItemsWithDetails = [];
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $product = productsModel::getByPK($item->getProductID());
            if ($product) {
                // Fetch photos for the product
                $photos = productPhotosModel::getPhotosByProductId($item->getProductID());
                $cartItemsWithDetails[] = [
                    'cart_item_id' => $item->getCartItemID(),
                    'product_id' => $item->getProductID(),
                    'name' => $product->getName(),
                    'photo_url' => !empty($photos) ? $photos[0] : 'default.jpg', // Use the first photo or a default
                    'unit_price' => $product->getUnitPrice(),
                    'quantity' => $item->getQuantity(),
                ];
                $subtotal += $item->getQuantity() * $product->getUnitPrice();
            }
        }

        // Calculate tax and total
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        // Pass data to the view
        $this->_data['cart_items'] = $cartItemsWithDetails;
        $this->_data['subtotal'] = $subtotal;
        $this->_data['tax'] = $tax;
        $this->_data['total'] = $total;

        // Render the view
        $this->_view();
    }

    public function updateQuantityAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirectWithAlert('warning', '/login', 'Please sign in to update your cart.');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $this->filterInt($_POST['cart_item_id']);
            $quantity = $this->filterInt($_POST['quantity']);

            if ($quantity < 1) {
                $this->redirectWithAlert('error', '/cart', 'Quantity must be at least 1.');
                return;
            }

            $cartItem = cartItemsModel::getByPK($cartItemId);
            if ($cartItem && $cartItem->getUserID() === $_SESSION['user']['user_id']) {
                $cartItem->setQuantity($quantity);
                if ($cartItem->save()) {
                    $this->redirectWithAlert('success', '/cart', 'Quantity updated successfully.');
                } else {
                    $this->redirectWithAlert('error', '/cart', 'Failed to update quantity.');
                }
            } else {
                $this->redirectWithAlert('error', '/cart', 'Invalid cart item.');
            }
        }
    }

    public function removeItemAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirectWithAlert('warning', '/login', 'Please sign in to remove items from your cart.');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $this->filterInt($_POST['cart_item_id']);

            $cartItem = cartItemsModel::getByPK($cartItemId);
            if ($cartItem && $cartItem->getUserID() === $_SESSION['user']['id']) {
                if ($cartItem->delete()) {
                    $this->redirectWithAlert('success', '/cart', 'Item removed successfully.');
                } else {
                    $this->redirectWithAlert('error', '/cart', 'Failed to remove item.');
                }
            } else {
                $this->redirectWithAlert('error', '/cart', 'Invalid cart item.');
            }
        }
    }

    public function checkoutAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirectWithAlert('warning', '/login', 'Please sign in to proceed to checkout.');
            return;
        }

        // Clear the cart after checkout
        $userId = $_SESSION['user']['id'];
        $cartItems = cartItemsModel::getBy(['user_id' => $userId]);
        foreach ($cartItems as $item) {
            $item->delete();
        }

        $this->redirectWithAlert('success', '/', 'Checkout successful. Thank you for your purchase!');
    }

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
}
