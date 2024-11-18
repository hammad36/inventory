<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class productPhotosModel extends abstractModel
{
    use inputFilter;

    protected $photo_id;
    protected $product_id;
    protected $photo_url;
    protected $uploaded_at;

    protected static $tableName = 'product_photos';
    protected static $tableSchema = [
        'product_id' => self::DATA_TYPE_INT,
        'photo_url'  => self::DATA_TYPE_STR,
        'uploaded_at' => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'photo_id';

    public function setProductId(int $product_id): void
    {
        $this->product_id = $this->filterInt($product_id);
    }

    public function setPhotoUrl(string $photo_url): void
    {
        $this->photo_url = $this->filterUrl($photo_url);
    }

    public function setUploadedAt(string $uploaded_at): void
    {
        $this->uploaded_at = $this->filterDate($uploaded_at);
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
}
