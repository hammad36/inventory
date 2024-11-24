<?php

namespace inventory\models;

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
    public function getProductId()
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

    public function setName($name)
    {
        $this->name = $this->filterString($name, 3, 100);
    }

    public function setSku($sku)
    {
        $this->sku = $this->filterString($sku, 1, 50);
    }

    public function setDescription($description)
    {
        $this->description = $this->filterString($description, 0, 500);
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $this->filterInt($quantity);
    }

    public function setUnitPrice($price)
    {
        $this->unit_price = $this->filterFloat($price);
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $this->filterInt($category_id);
    }

    public function setCreatedAt($date)
    {
        $this->created_at = $this->filterDate($date);
    }

    public function setUpdatedAt($date)
    {
        $this->updated_at = $this->filterDate($date);
    }

    // Static methods
    public static function getByPK($categoryId)
    {
        $db = databaseHandler::factory();
        $query = 'SELECT * FROM ' . self::$tableName . ' WHERE category_id = :category_id';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->execute();

        // Ensure we return an array of product objects
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
}
