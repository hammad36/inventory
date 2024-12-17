<?php

namespace inventory\models;

use inventory\lib\InputFilter;

class StockAdjustmentsModel extends AbstractModel
{
    use InputFilter;

    // Properties
    protected $adjustment_id;
    protected $product_id;
    protected $product_name;
    protected $change_type;
    protected $quantity_change;
    protected $user_id;
    protected $user_name;
    protected $timestamp;

    // Table and Schema
    protected static $tableName = 'stock_adjustments';
    protected static $tableSchema = [
        'product_id'       => self::DATA_TYPE_INT,
        'product_name'     => self::DATA_TYPE_STR,
        'change_type'      => self::DATA_TYPE_STR,
        'quantity_change'  => self::DATA_TYPE_INT,
        'user_id'          => self::DATA_TYPE_INT,
        'user_name'        => self::DATA_TYPE_STR,
        'timestamp'        => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'adjustment_id';

    // Methods to dynamically set related data
    private function setProductNameFromId(): void
    {
        $product = ProductsModel::getByPK($this->product_id);
        $this->product_name = $product ? $product->getName() : 'Unknown Product';
    }

    private function setUserNameFromId(): void
    {
        $user = UsersModel::getByPK($this->user_id);
        $this->user_name = $user ? $user->getFullName() : 'Unknown User';
    }

    // Override save method to include product_name and user_name
    public function save(): bool
    {
        if (!isset($this->user_name)) {
            $this->setUserNameFromId();
        }

        if (!isset($this->product_name)) {
            $this->setProductNameFromId();
        }

        return parent::save();
    }

    // Setters
    public function setProductId(int $product_id): void
    {
        $this->product_id = $this->filterInt($product_id);
    }

    public function setChangeType(string $change_type): void
    {
        $validTypes = [
            'addition',
            'reduction',
            'addProduct',
            'editProduct',
            'deleteProduct',
            'addCategory',
            'editCategory',
            'deleteCategory'
        ];

        if (!in_array($change_type, $validTypes)) {
            throw new \InvalidArgumentException(
                "Invalid change type. Allowed values are: " . implode(", ", $validTypes)
            );
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

    public function setProductQuantityChange(int $quantity_change): void
    {
        if ($quantity_change === 0) {
            throw new \InvalidArgumentException("Quantity change cannot be zero.");
        }

        $this->quantity_change = $this->filterInt($quantity_change);
    }


    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id !== null ? $this->filterInt($user_id) : null;
    }

    public function setTimestamp(?string $timestamp = null): void
    {
        $this->timestamp = $timestamp ?: date('Y-m-d H:i:s');
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

    public function getProductName(): string
    {
        return $this->product_name ?? 'N/A';
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

    public function getUserName(): string
    {
        return $this->user_name ?? 'N/A';
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    // Utility Methods
    public function isAddition(): bool
    {
        return $this->change_type === 'addition';
    }

    public function isReduction(): bool
    {
        return $this->change_type === 'reduction';
    }

    // Query Methods

    /**
     * Fetch adjustments filtered by a specific time period
     */
    public static function getFiltered(string $type): array
    {
        $condition = match ($type) {
            'daily'   => "DATE(timestamp) = CURDATE()",
            'weekly'  => "WEEK(timestamp, 1) = WEEK(CURDATE(), 1) AND YEAR(timestamp) = YEAR(CURDATE())",
            'monthly' => "MONTH(timestamp) = MONTH(CURDATE()) AND YEAR(timestamp) = YEAR(CURDATE())",
            'yearly'  => "YEAR(timestamp) = YEAR(CURDATE())",
            default   => '',
        };

        if (!$condition) return [];

        $sql = "SELECT * FROM stock_adjustments WHERE $condition";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Fetch recent stock adjustments
     */
    public static function getRecentAdjustments(int $limit = 10): array
    {
        $sql = "
        SELECT 
            sa.adjustment_id,
            sa.product_id,
            p.name AS product_name,
            sa.change_type,
            sa.quantity_change,
            sa.user_id,
            u.full_name AS user_name,
            sa.timestamp
        FROM 
            stock_adjustments sa
        LEFT JOIN 
            products p ON sa.product_id = p.product_id
        LEFT JOIN 
            users u ON sa.user_id = u.user_id
        ORDER BY 
            sa.timestamp DESC
        LIMIT :limit
        ";

        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, self::DATA_TYPE_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Fetch adjustments by product category
     */
    public static function getByCategoryId(int $categoryId): array
    {
        $sql = "
        SELECT sa.*
        FROM stock_adjustments sa
        INNER JOIN products p ON sa.product_id = p.product_id
        WHERE p.category_id = :category_id
        ";

        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, self::DATA_TYPE_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
    }
}
