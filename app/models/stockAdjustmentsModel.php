<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class stockAdjustmentsModel extends AbstractModel
{
    use inputFilter;

    // Properties
    protected $adjustment_id;
    protected $product_id;
    protected $change_type;
    protected $quantity_change;
    protected $user_id;
    protected $timestamp;

    // Table and Schema
    protected static $tableName = 'stock_adjustments';
    protected static $tableSchema = [
        'product_id'       => self::DATA_TYPE_INT,
        'change_type'      => self::DATA_TYPE_ENUM,
        'quantity_change'  => self::DATA_TYPE_INT,
        'user_id'          => self::DATA_TYPE_INT,
        'timestamp'        => self::DATA_TYPE_TIMESTAMP,
    ];

    protected static $primaryKey = 'adjustment_id';

    // Data Types
    const DATA_TYPE_BOOL    = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR     = \PDO::PARAM_STR;
    const DATA_TYPE_INT     = \PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL = 4;
    const DATA_TYPE_DATE    = \PDO::PARAM_STR;
    const DATA_TYPE_NULL    = \PDO::PARAM_NULL;
    const DATA_TYPE_ENUM    = 'enum';
    const DATA_TYPE_TIMESTAMP = 'timestamp';

    // Setters with validation
    public function setProductId(int $product_id): void
    {
        $this->product_id = $this->filterInt($product_id);
    }

    public function setChangeType(string $change_type): void
    {
        $validTypes = ['addition', 'reduction'];
        if (!in_array($change_type, $validTypes)) {
            throw new \InvalidArgumentException("Invalid change type. Allowed values are: addition, reduction.");
        }
        $this->change_type = $change_type;
    }

    public function setQuantityChange(int $quantity_change): void
    {
        if ($quantity_change <= 0) {
            throw new \InvalidArgumentException("Quantity change must be a positive integer.");
        }
        $this->quantity_change = $this->filterInt($quantity_change);
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id !== null ? $this->filterInt($user_id) : null;
    }

    public function setTimestamp(?string $timestamp = null): void
    {
        $this->timestamp = $timestamp ? $this->filterDate($timestamp) : date('Y-m-d H:i:s');
    }

    // Getters
    public function getAdjustmentId(): int
    {
        return $this->adjustment_id;
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

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    // Utility methods (optional)
    public function isAddition(): bool
    {
        return $this->change_type === 'addition';
    }

    public function isReduction(): bool
    {
        return $this->change_type === 'reduction';
    }
}
