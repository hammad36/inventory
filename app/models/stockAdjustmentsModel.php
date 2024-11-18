<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class stockAdjustmentsModel extends abstractModel
{
    use inputFilter;

    protected $adjustment_id;
    protected $product_id;
    protected $change_type;
    protected $quantity_change;
    protected $user_id;
    protected $timestamp;

    protected static $tableName = 'stock_adjustments';
    protected static $tableSchema = [
        'product_id'       => self::DATA_TYPE_INT,
        'change_type'      => self::DATA_TYPE_STR,
        'quantity_change'  => self::DATA_TYPE_INT,
        'user_id'          => self::DATA_TYPE_INT,
        'timestamp'        => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'adjustment_id';

    public function setProductId(int $product_id): void
    {
        $this->product_id = $this->filterInt($product_id);
    }

    public function setChangeType(string $change_type): void
    {
        $validTypes = ['addition', 'reduction'];
        $this->change_type = in_array($change_type, $validTypes) ? $change_type : throw new \Exception("Invalid change type.");
    }

    public function setQuantityChange(int $quantity_change): void
    {
        $this->quantity_change = $this->filterInt($quantity_change);
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $this->filterInt($user_id);
    }

    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $this->filterDate($timestamp);
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getChangeType(): string
    {
        return $this->change_type;
    }

    public function getQuantityChange(): int
    {
        return $this->quantity_change;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }
}
