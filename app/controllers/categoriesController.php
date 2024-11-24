<?php

namespace inventory\controllers;

use inventory\controllers\abstractController;
use inventory\lib\InputFilter;
use inventory\lib\alertHandler;
use inventory\models\categoriesModel;
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

        $this->_data = [
            'category' => $category,
            'products' => productPhotosModel::getByCategoryId($categoryId),
        ];

        $this->_view();
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
            $this->_view();
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
            $this->_view();
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
        $this->_view();
    }


    public function manageProductsAction()
    {
        $this->renderCategoriesView(categoriesModel::getAll());
    }


    private function redirectWithAlert(string $alertType, string $url, string $message)
    {
        $this->alertHandler->redirectWithMessage($url, $alertType, $message);
    }
}
