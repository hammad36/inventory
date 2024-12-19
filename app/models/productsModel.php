<?php

namespace inventory\models;

use inventory\lib\alertHandler;
use inventory\lib\database\databaseHandler;
use inventory\lib\InputFilter;

class productsModel extends abstractModel
{
    use InputFilter;

    // Class properties
    protected $product_id;
    protected $product_name;
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
        'product_name' => self::DATA_TYPE_STR,
        'sku'          => self::DATA_TYPE_STR,
        'description'  => self::DATA_TYPE_STR,
        'quantity'     => self::DATA_TYPE_INT,
        'unit_price'   => self::DATA_TYPE_INT,
        'category_id'  => self::DATA_TYPE_INT,
        'created_at'   => self::DATA_TYPE_DATE,
        'updated_at'   => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'product_id';

    // Getters
    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function getName(): string
    {
        return $this->product_name;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function getPhotoUrl(): string
    {
        return $this->photo_url ?? 'default.jpg';
    }

    // Setters
    public function setName(string $product_name): void
    {
        $this->product_name = $product_name;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setUnitPrice(int $unit_price): void
    {
        $this->unit_price = $unit_price;
    }

    public function setCategoryId(?int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    // Fetch product with photos
    public static function getProductWithPhotos(int $productId): ?self
    {
        $product = self::getByPK($productId);
        if ($product) {
            $photosGrouped = productPhotosModel::getPhotosGroupedByProductId([$productId]);
            $product->photos = $photosGrouped[$productId] ?? [];
        }
        return $product;
    }

    // Save product with photos
    public function saveWithPhotos(array $photoUrls): bool
    {
        $db = databaseHandler::factory();
        $db->beginTransaction();

        try {
            if (!$this->save()) {
                throw new \Exception('Error saving product.');
            }

            $productId = $this->getProductId();

            if (!productPhotosModel::deletePhotosByProductId($productId)) {
                throw new \Exception('Error deleting old product photos.');
            }

            foreach ($photoUrls as $url) {
                if (!empty($url)) {
                    $photo = new productPhotosModel();
                    $photo->setProductId($productId);
                    $photo->setPhotoUrl($url);

                    if (!$photo->save()) {
                        throw new \Exception("Error saving photo: $url");
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

    // Delete product with photos
    public function deleteWithPhotos(): bool
    {
        $db = databaseHandler::factory();
        $db->beginTransaction();

        try {
            $productId = $this->getProductId();

            if (!productPhotosModel::deletePhotosByProductId($productId)) {
                throw new \Exception('Error deleting product photos.');
            }

            if (!$this->delete()) {
                throw new \Exception('Error deleting product.');
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
