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
            // Redirect to index page with a message
            $this->redirectWithAlert('warning', '/index', 'Please sign in to view your cart.');
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
            $this->redirectWithAlert('warning', '/index', 'Please sign in to update your cart.');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $this->filterInt($_POST['cart_item_id']);
            $action = $_POST['action'] ?? '';
            $quantity = $this->filterInt($_POST['quantity']);

            $cartItem = cartItemsModel::getByPK($cartItemId);
            if ($cartItem && $cartItem->getUserID() === $_SESSION['user']['id']) {
                if ($action === 'increase') {
                    $quantity++;
                } elseif ($action === 'decrease') {
                    $quantity = max(1, $quantity - 1);
                }

                $cartItem->setQuantity($quantity);
                if ($cartItem->save()) {
                    $this->redirectOnly('/cart');
                } else {
                    $this->redirectOnly('/cart');
                }
            } else {
                $this->redirectOnly('error');
            }
        }
    }


    public function removeItemAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirectWithAlert('warning', '/index', 'Please sign in to remove items from your cart.');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $this->filterInt($_POST['cart_item_id']);

            $cartItem = cartItemsModel::getByPK($cartItemId);
            if ($cartItem && $cartItem->getUserID() === $_SESSION['user']['id']) {
                if ($cartItem->delete()) {
                    $this->redirectOnly('/cart');
                } else {
                    $this->redirectOnly('/cart');
                }
            } else {
                $this->redirectOnly('/cart');
            }
        }
    }


    public function checkoutAction()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user'])) {
            $this->redirectWithAlert('warning', '/index', 'Please sign in to proceed to checkout.');
            return;
        }

        // Fetch cart items for the logged-in user
        $userId = $_SESSION['user']['id'];
        $cartItems = cartItemsModel::getBy(['user_id' => $userId]);

        // Calculate subtotal, tax, and total
        $subtotal = 0;
        $cartItemsWithDetails = [];
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

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
    private function redirectOnly(string $url): void
    {
        $this->alertHandler->redirectOnly($url);
    }

    public function confirmOrderAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirectWithAlert('warning', '/index', 'Please sign in to confirm your order.');
            return;
        }

        // Fetch cart items for the logged-in user
        $userId = $_SESSION['user']['id'];
        $cartItems = cartItemsModel::getBy(['user_id' => $userId]);

        // Calculate subtotal, tax, and total
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $product = productsModel::getByPK($item->getProductID());
            if ($product) {
                $subtotal += $item->getQuantity() * $product->getUnitPrice();
            }
        }
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        // Generate invoice (this is a simple example, you can expand it)
        $invoice = [
            'user' => $_SESSION['user'],
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'date' => date('Y-m-d H:i:s'),
        ];

        // Save the invoice to the database or generate a PDF (not shown here)

        // Clear the cart
        foreach ($cartItems as $item) {
            $item->delete();
        }

        // Redirect to a thank you page or display the invoice
        $this->redirectWithAlert('success', '/thankYou', 'Your order has been confirmed. Thank you for your purchase!');
    }
}
