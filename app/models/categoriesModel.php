<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class categoriesModel extends abstractModel
{
    use inputFilter;

    protected $category_id;
    protected $name;
    protected $description;

    protected static $tableName = 'categories';
    protected static $tableSchema = [
        'name'        => self::DATA_TYPE_STR,
        'description' => self::DATA_TYPE_STR,
    ];

    protected static $primaryKey = 'category_id';

    public function setName(string $name): void
    {
        $this->name = $this->filterString($name, 3, 50);
    }

    public function setDescription(string $description): void
    {
        $this->description = $this->filterString($description, 0, 255);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
