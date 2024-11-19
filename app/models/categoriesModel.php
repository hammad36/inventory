<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class categoriesModel extends abstractModel
{
    use inputFilter;

    protected $category_id;
    protected $name;
    protected $description;
    protected $photo_url;

    protected static $tableName = 'categories';
    protected static $tableSchema = [
        'name'        => self::DATA_TYPE_STR,
        'description' => self::DATA_TYPE_STR,
        'photo_url'   => self::DATA_TYPE_STR,
    ];
    protected static $primaryKey = 'category_id';

    public function setName(string $name): void
    {
        if (strlen($name) < 3 || strlen($name) > 50) {
            throw new \InvalidArgumentException("Category name must be between 3 and 50 characters.");
        }
        $this->name = $this->filterString($name);
    }

    public function setDescription(?string $description): void
    {
        $this->description = $this->filterString($description, 0, 255);
    }

    public function setPhotoUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Invalid photo URL.");
        }
        $this->photo_url = $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPhotoUrl(): string
    {
        return $this->photo_url;
    }
}
