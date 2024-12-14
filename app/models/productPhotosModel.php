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
        'product_id' => self::DATA_TYPE_INT,
        'photo_url'  => self::DATA_TYPE_STR,
        'uploaded_at' => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'photo_id';

    // Setters and Getters
    public function setProductId(int $product_id): void
    {
        $this->product_id = $this->filterInt($product_id);
    }

    public function setPhotoUrl(string $photo_url): void
    {
        $this->photo_url = $this->filterUrl($photo_url);
    }

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
            return array_column($result, 'photo_urls', 'product_id'); // Map by product_id
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

    // Add multiple photos at once
    public static function addPhotosToProduct(int $productId, array $photoUrls): bool
    {
        if (empty($photoUrls)) {
            return false;
        }

        return self::executeWithConnection(function ($connection) use ($productId, $photoUrls) {
            $sql = 'INSERT INTO product_photos (product_id, photo_url, uploaded_at) VALUES ';
            $values = [];
            $placeholders = [];

            $date = date('Y-m-d H:i:s'); // Current timestamp for `uploaded_at`
            foreach ($photoUrls as $photoUrl) {
                $placeholders[] = '(:product_id, :photo_url, :uploaded_at)';
                $values[] = ['product_id' => $productId, 'photo_url' => $photoUrl, 'uploaded_at' => $date];
            }

            $sql .= implode(',', $placeholders);

            $stmt = $connection->prepare($sql);
            foreach ($values as $index => $data) {
                $stmt->bindValue(":product_id", $data['product_id'], \PDO::PARAM_INT);
                $stmt->bindValue(":photo_url", $data['photo_url'], \PDO::PARAM_STR);
                $stmt->bindValue(":uploaded_at", $data['uploaded_at'], \PDO::PARAM_STR);
            }

            return $stmt->execute();
        });
    }

    // Fetch products with their associated photos by category ID
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

    // Handle transactions for adding, deleting photos
    public static function handlePhotoTransaction(callable $operation): bool
    {
        $db = databaseHandler::factory();
        $db->beginTransaction();
        try {
            if ($operation()) {
                $db->commit();
                return true;
            } else {
                throw new \Exception('Failed to perform operation on photos.');
            }
        } catch (\Exception $e) {
            $db->rollBack();
            alertHandler::getInstance()->displayAlert('error', $e->getMessage());
            return false;
        }
    }

    public static function getPhotosByProductId(int $productId): array
    {
        try {
            // Establish a database connection
            $db = databaseHandler::factory();
            if (!$db) {
                throw new \Exception('Database connection not established.');
            }

            // Prepare the query
            $query = "SELECT photo_url FROM product_photos WHERE product_id = :product_id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);

            // Execute the query
            if (!$stmt->execute()) {
                throw new \Exception('Failed to execute query: ' . implode(' | ', $stmt->errorInfo()));
            }

            // Fetch and return results
            $photos = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            return $photos ?: []; // Return an empty array if no results are found

        } catch (\Exception $e) {
            // Log error or handle as needed
            error_log($e->getMessage());
            return []; // Return an empty array on failure
        }
    }
}
