<?php

namespace inventory\models;

use inventory\lib\alertHandler;
use inventory\lib\database\databaseHandler;
use inventory\lib\inputFilter;

class productPhotosModel extends abstractModel
{
    use inputFilter;

    // Class properties
    protected $photo_id;
    protected $product_id;
    protected $photo_url;
    protected $uploaded_at;

    // Database schema
    protected static $tableName = 'product_photos';
    protected static $tableSchema = [
        'product_id'  => self::DATA_TYPE_INT,
        'photo_url'   => self::DATA_TYPE_STR,
        'uploaded_at' => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'photo_id';

    // Setters
    public function setProductId(int $product_id): void
    {
        $this->product_id = $this->filterInt($product_id);
    }

    public function setPhotoUrl(string $photo_url): void
    {
        $this->photo_url = $this->filterUrl($photo_url);
    }

    // Getters
    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getPhotoUrl(): string
    {
        return $this->photo_url;
    }

    public function getUploadedAt(): string
    {
        return $this->uploaded_at;
    }

    // Get photos grouped by product_id
    public static function getPhotosGroupedByProductId(array $productIds): array
    {
        return self::executeWithConnection(function ($connection) use ($productIds) {
            $placeholders = implode(',', array_fill(0, count($productIds), '?'));
            $sql = "SELECT product_id, GROUP_CONCAT(photo_url) AS photo_urls
                    FROM product_photos
                    WHERE product_id IN ($placeholders)
                    GROUP BY product_id";

            $stmt = $connection->prepare($sql);
            $stmt->execute($productIds);

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return array_column($result, 'photo_urls', 'product_id');
        });
    }

    // Delete photos by product_id
    public static function deletePhotosByProductId(int $productId): bool
    {
        return self::executeWithConnection(function ($connection) use ($productId) {
            $sql = 'DELETE FROM product_photos WHERE product_id = :product_id';
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
            return $stmt->execute();
        });
    }

    // Add multiple photos to a product
    public static function addPhotosToProduct(int $productId, array $photoUrls): bool
    {
        if (empty($photoUrls)) {
            return false;
        }

        return self::executeWithConnection(function ($connection) use ($productId, $photoUrls) {
            $sql = 'INSERT INTO product_photos (product_id, photo_url, uploaded_at) VALUES ';
            $placeholders = [];
            $params = [];
            $timestamp = date('Y-m-d H:i:s');

            foreach ($photoUrls as $index => $url) {
                $placeholders[] = "(:product_id_{$index}, :photo_url_{$index}, :uploaded_at_{$index})";
                $params[":product_id_{$index}"] = $productId;
                $params[":photo_url_{$index}"] = $url;
                $params[":uploaded_at_{$index}"] = $timestamp;
            }

            $sql .= implode(', ', $placeholders);
            $stmt = $connection->prepare($sql);

            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value, \PDO::PARAM_STR);
            }

            return $stmt->execute();
        });
    }

    // Fetch products with photos by category ID
    public static function getByCategoryId(int $categoryId): array
    {
        return self::executeWithConnection(function ($connection) use ($categoryId) {
            $sql = 'SELECT 
                        p.product_id, 
                        p.product_name, 
                        p.description,
                        p.sku, 
                        p.unit_price,
                        p.quantity,
                        p.category_id,
                        GROUP_CONCAT(pp.photo_url) AS photo_urls
                    FROM products p
                    LEFT JOIN product_photos pp ON pp.product_id = p.product_id
                    WHERE p.category_id = :category_id
                    GROUP BY p.product_id';

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        });
    }

    // Fetch photos by product ID
    public static function getPhotosByProductId($productId)
    {
        $sql = "SELECT photo_url FROM product_photos WHERE product_id = :product_id";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindParam(':product_id', $productId, \PDO::PARAM_INT);
        $stmt->execute();

        $photos = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $photos[] = $row['photo_url'];
        }
        return $photos;
    }


    // Transaction wrapper for photo operations
    public static function handlePhotoTransaction(callable $operation): bool
    {
        $db = databaseHandler::factory();
        $db->beginTransaction();
        try {
            if ($operation()) {
                $db->commit();
                return true;
            }
            throw new \Exception('Failed to complete photo transaction.');
        } catch (\Exception $e) {
            $db->rollBack();
            alertHandler::getInstance()->displayAlert('error', $e->getMessage());
            return false;
        }
    }
}
