<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class productsModel extends abstractModel
{
    use inputFilter;

    protected $product_id;
    protected $name;
    protected $category_id;
    protected $stock;
    protected $price;
    protected $description;
    protected $created_at;
    protected $updated_at;

    protected static $tableName = 'products';
    protected static $tableSchema = [
        'name'          => self::DATA_TYPE_STR,
        'category_id'   => self::DATA_TYPE_INT,
        'stock'         => self::DATA_TYPE_INT,
        'price'         => self::DATA_TYPE_DECIMAL,
        'description'   => self::DATA_TYPE_STR,
        'created_at'    => self::DATA_TYPE_DATE,
        'updated_at'    => self::DATA_TYPE_DATE
    ];

    protected static $primaryKey = 'product_id';

    public function setName($name)
    {
        $this->name = $this->filterString($name, 3, 100);
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $this->filterInt($category_id);
    }

    public function setStock($stock)
    {
        $this->stock = $this->filterInt($stock);
    }

    public function setPrice($price)
    {
        $this->price = $this->filterFloat($price);
    }

    public function setDescription($description)
    {
        $this->description = $this->filterString($description, 0, 500);
    }

    public function setCreatedAt($date)
    {
        $this->created_at = $this->filterDate($date);
    }

    public function setUpdatedAt($date)
    {
        $this->updated_at = $this->filterDate($date);
    }
}
