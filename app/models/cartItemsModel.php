<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class cartItemsModel extends abstractModel
{
    use inputFilter;

    // Properties
    protected $cart_item_id;
    protected $user_id;
    protected $product_id;
    protected $quantity;
    protected $added_at;

    // Table and Schema
    protected static $tableName = 'cart_items';
    protected static $tableSchema = [
        'user_id'       => self::DATA_TYPE_INT,
        'product_id'     => self::DATA_TYPE_INT,
        'quantity'  => self::DATA_TYPE_INT,
        'added_at'        => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'cart_item_id';


    // Setters
    public function setUserID(?string $user_id = null): void
    {
        $this->user_id = $this->filterInt($user_id);
    }

    public function setProductID(?string $product_id = null): void
    {
        $this->product_id = $this->filterInt($product_id);
    }

    public function setQuantity(?string $quantity = null): void
    {
        $quantity = $this->filterInt($quantity);
        if ($quantity < 0) {
            throw new \InvalidArgumentException("Quantity cannot be negative.");
        }
        $this->quantity = $quantity;
    }

    public function setAddedAt(?string $added_at = null): void
    {
        $this->added_at = $added_at ?: date('Y-m-d H:i:s');
    }

    // Getters
    public function getCartItemID(): int
    {
        return $this->cart_item_id;
    }

    public function getUserID(): int
    {
        return $this->user_id;
    }

    public function getProductID(): int
    {
        return $this->product_id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getAddedAt(): string
    {
        return $this->added_at;
    }

    ///
    public static function getBy(array $conditions)
    {
        return self::executeWithConnection(function ($connection) use ($conditions) {
            $whereClause = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));
            $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . $whereClause;

            $stmt = $connection->prepare($sql);

            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value, static::$tableSchema[$key] ?? self::DATA_TYPE_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());
        });
    }
}
