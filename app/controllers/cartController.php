<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\alertHandler;
use inventory\lib\inputFilter;
use inventory\lib\KashierPayment;
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


    public function checkOutAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirectWithAlert('warning', '/index', 'Please sign in to checkout.');
            return;
        }

        // Get cart items and calculate total
        $userId = $_SESSION['user']['id'];
        $cartItems = cartItemsModel::getBy(['user_id' => $userId]);

        $total = 0;
        foreach ($cartItems as $item) {
            $product = productsModel::getByPK($item->getProductID());
            if ($product) {
                $total += $item->getQuantity() * $product->getUnitPrice();
            }
        }

        // Add 10% tax
        $total = $total + ($total * 0.1);

        // Generate unique order ID
        $orderId = 'ORD-' . time() . '-' . $userId;

        // Store order details in session for validation after payment
        $_SESSION['pending_order'] = [
            'order_id' => $orderId,
            'amount' => $total,
            'user_id' => $userId
        ];

        // Generate payment URL
        $successRedirect = 'http://inventory.local/cart/success';
        $failureRedirect = 'http://inventory.local/cart/failure';

        $paymentUrl = KashierPayment::generatePaymentUrl(
            $orderId,
            $total,
            $successRedirect,
            $failureRedirect
        );

        // Redirect to Kashier checkout
        header("Location: " . $paymentUrl);
        exit;
    }

    public function successAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validate the payment response signature
        if (!KashierPayment::validateSignature($_GET)) {
            // Invalid signature
            $this->redirectWithAlert('error', '/cart', 'Invalid payment signature');
            return;
        }

        // Check payment status
        if ($_GET['paymentStatus'] !== 'SUCCESS') {
            $this->redirectWithAlert('error', '/cart', 'Payment was not successful');
            return;
        }

        // Verify order details match what we expect
        if (
            !isset($_SESSION['pending_order']) ||
            $_SESSION['pending_order']['order_id'] !== $_GET['merchantOrderId'] ||
            $_SESSION['pending_order']['amount'] != $_GET['amount']
        ) {
            $this->redirectWithAlert('error', '/cart', 'Order details mismatch');
            return;
        }

        try {
            // Get additional payment details from response
            $transactionId = $_GET['transactionId'] ?? null;
            $cardBrand = $_GET['cardBrand'] ?? null;
            $maskedCard = $_GET['maskedCard'] ?? null;
            $orderReference = $_GET['orderReference'] ?? null;

            // TODO: Save order and payment details to database
            // TODO: Clear cart
            // TODO: Send confirmation email

            unset($_SESSION['pending_order']);
            $this->redirectWithAlert('success', '/orders', 'Payment successful! Your order has been placed.');
        } catch (\Exception $e) {
            // Log the error
            error_log("Payment processing error: " . $e->getMessage());
            $this->redirectWithAlert('error', '/cart', 'An error occurred while processing your payment.');
        }
    }

    public function failureAction()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clean up pending order
        unset($_SESSION['pending_order']);

        $this->redirectWithAlert('error', '/cart', 'Payment failed. Please try again.');
    }

    public function webhookAction()
    {
        try {
            $rawPostData = file_get_contents('php://input');
            $webhookData = KashierPayment::handleWebhook($rawPostData);

            // Process webhook data
            if ($webhookData['paymentStatus'] === 'SUCCESS') {
                // TODO: Update order status in database
                // TODO: Trigger any necessary background processes
            }

            http_response_code(200);
            echo json_encode(['status' => 'success']);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function redirectWithAlert(string $type, string $url, string $message): void
    {
        $this->alertHandler->redirectWithAlert($url, $type, $message);
    }
    private function redirectOnly(string $url): void
    {
        $this->alertHandler->redirectOnly($url);
    }
}
