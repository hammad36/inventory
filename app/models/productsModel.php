<?php

namespace inventory\models;

use inventory\lib\alertHandler;
use inventory\lib\database\databaseHandler;
use inventory\lib\inputFilter;

class productsModel extends abstractModel
{
    use inputFilter;

    // Class properties
    protected $product_id;
    protected $name;
    protected $sku;
    protected $description;
    protected $quantity;
    protected $unit_price;
    protected $category_id;
    protected $created_at;
    protected $updated_at;

    // Database schema
    protected static $tableName = 'products';
    protected static $tableSchema = [
        'name'        => self::DATA_TYPE_STR,
        'sku'         => self::DATA_TYPE_STR,
        'description' => self::DATA_TYPE_STR,
        'quantity'    => self::DATA_TYPE_INT,
        'unit_price'  => self::DATA_TYPE_DECIMAL,
        'category_id' => self::DATA_TYPE_INT,
        'created_at'  => self::DATA_TYPE_DATE,
        'updated_at'  => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'product_id';

    // Getters
    public function getProductID()
    {
        return $this->product_id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getSku()
    {
        return $this->sku;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getUnitPrice()
    {
        return $this->unit_price;
    }
    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function getPhotoUrl()
    {
        return $this->photo_url ?? 'default.jpg';
    }


    //Setter
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setUnitPrice($unit_price)
    {
        $this->unit_price = $unit_price;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function setCategoryID($category_id)
    {
        $this->category_id = $category_id;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->category_id = $updated_at;
    }

    // Method to fetch product with photos
    public static function getProductWithPhotos(int $productId): ?self
    {
        $product = self::getByPK($productId); // Fetch product by primary key
        if ($product) {
            // Fetch photos grouped by product_id
            $photosGrouped = productPhotosModel::getPhotosGroupedByProductId([$productId]);
            $product->photos = $photosGrouped[$productId] ?? []; // Get photos for this product
        }
        return $product;
    }



    // Enhanced save with photos method
    public function saveWithPhotos(array $photoUrls): bool
    {
        $db = databaseHandler::factory();
        $db->beginTransaction();

        try {
            if (!$this->save()) {
                throw new \Exception('Failed to save product.');
            }

            $productId = $this->getProductId();

            // Delete existing photos
            if (!productPhotosModel::deletePhotosByProductId($productId)) {
                throw new \Exception('Failed to delete existing photos.');
            }

            // Add new photos
            foreach ($photoUrls as $url) {
                if (!empty($url)) {
                    $photo = new productPhotosModel();
                    $photo->setProductId($productId);
                    $photo->setPhotoUrl($url);
                    if (!$photo->save()) {
                        throw new \Exception('Failed to save product photo.');
                    }
                }
            }

            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            alertHandler::getInstance()->displayAlert('error', $e->getMessage());
            return false;
        }
    }

    // Enhanced delete with photos method
    public function deleteWithPhotos(): bool
    {
        $db = databaseHandler::factory();
        $db->beginTransaction();

        try {
            $productId = $this->getProductId();

            if (!productPhotosModel::deletePhotosByProductId($productId)) {
                throw new \Exception('Failed to delete associated photos.');
            }

            if (!$this->delete()) {
                throw new \Exception('Failed to delete product.');
            }

            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            alertHandler::getInstance()->displayAlert('error', $e->getMessage());
            return false;
        }
    }
}
