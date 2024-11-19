<?php

namespace inventory\controllers;

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
        $categories = categoriesModel::getAll();  // Returns a collection of category objects
        $this->_data['categories'] = $categories;

        $this->_view();  // Call the view to render
    }


    // New action to show products by category
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
}
