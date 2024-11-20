<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\categoriesModel;
use inventory\models\productsModel;
use inventory\models\productPhotosModel;

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
        $categories = categoriesModel::getAll();  // Returns a collection of category objects
        $this->_data['categories'] = $categories;

        $this->_view();  // Call the view to render
    }

    // Show products by category
    public function categoryAction($categoryId)
    {
        $category = categoriesModel::getByPK($categoryId);
        if ($category) {
            $this->_data['category'] = $category;

            // Fetch products with photos for the category
            $this->_data['products'] = productPhotosModel::getByCategoryId($categoryId);

            $this->_view(); // Render the view
        } else {
            // Redirect with an error message if category is not found
            $this->alertHandler->redirectWithMessage('/categories', 'error', "Category not found.");
        }
    }

    // Show form to add a new product
    public function addProductFormAction($categoryId)
    {
        $category = categoriesModel::getByPK($categoryId);
        if ($category) {
            $this->_data['category'] = $category;

            $this->_view(); // Render the product form view
        } else {
            $this->alertHandler->redirectWithMessage('/categories', 'error', "Category not found.");
        }
    }

    public function manageCategoriesAction()
    {
        $categories = categoriesModel::getAll(); // Fetch all categories
        $this->_data['categories'] = $categories;
        $this->_view(); // Render the overview view
    }

    public function addNewCategoryAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and validate form data
            $name = $this->filterString($_POST['name']);
            $description = $this->filterString($_POST['description']);
            $photo_url = $this->filterString($_POST['photo_url']);

            // Validate the inputs
            if (empty($name) || empty($description) || empty($photo_url)) {
                $this->alertHandler->redirectWithMessage('/categories/manageCategories/AddNewCategory', 'error', "All fields are required.");
                return;
            }

            // Create a new category object
            $category = new categoriesModel();
            $category->setName($name);
            $category->setDescription($description);
            $category->setPhotoUrl($photo_url);

            // Save the category
            if ($category->save()) {
                $this->alertHandler->redirectWithMessage('/categories/manageCategories', 'success', "Category added successfully.");
            } else {
                $this->alertHandler->redirectWithMessage('/categories/manageCategories/AddNewCategory', 'error', "Failed to add category.");
            }
        } else {
            // Render the form for GET requests
            $this->_view();
        }
    }



    // Handle form submission to add a new product
    public function addProductAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->filterString($_POST['name']);
            $description = $this->filterString($_POST['description']);
            $price = $this->filterFloat($_POST['price']);
            $quantity = $this->filterInt($_POST['quantity']);
            $categoryId = $this->filterInt($_POST['category_id']);
            $photos = $_FILES['photos'] ?? null;

            $category = categoriesModel::getByPK($categoryId);
            if (!$category) {
                $this->alertHandler->redirectWithMessage('/categories', 'error', "Invalid category.");
                return;
            }

            $product = new productsModel();
            $product->setName($name);
            $product->setDescription($description);
            $product->setUnitPrice($price);
            $product->setQuantity($quantity);
            $product->setCategoryId($categoryId);

            if ($product->save()) {
                if ($photos && is_array($photos['tmp_name'])) {
                    foreach ($photos['tmp_name'] as $index => $tmpName) {
                        if (is_uploaded_file($tmpName)) {
                            $photoName = basename($photos['name'][$index]);
                            $photoPath = "/uploads/products/" . $photoName;

                            if (move_uploaded_file($tmpName, $_SERVER['DOCUMENT_ROOT'] . $photoPath)) {
                                $photo = new productPhotosModel();
                                $photo->setProductId($product->getProductId());
                                $photo->getPhotoUrl($photoPath);
                                $photo->save();
                            }
                        }
                    }
                }

                $this->alertHandler->redirectWithMessage("/categories/category/$categoryId", 'success', "Product added successfully.");
            } else {
                $this->alertHandler->redirectWithMessage("/categories/category/$categoryId", 'error', "Failed to add product.");
            }
        } else {
            $this->alertHandler->redirectWithMessage('/categories', 'error', "Invalid request.");
        }
    }
}
