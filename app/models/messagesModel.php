<?php

namespace inventory\models;

use inventory\lib\InputFilter;

class messagesModel extends abstractModel
{
    use InputFilter;

    protected $message_id;
    protected $name;
    protected $email;
    protected $message_text;

    protected static $tableName = 'messages';
    protected static $tableSchema = [
        'name'              => self::DATA_TYPE_STR,
        'email'             => self::DATA_TYPE_STR,
        'message_text'           => self::DATA_TYPE_STR,
    ];
    protected static $primaryKey = 'message_id';

    public function setName(string $name): void
    {
        $this->name = $this->filterString($name);
    }

    public function setEmail(string $email): void
    {
        $this->email = $this->filterString($email);
    }

    public function setMessageText(string $message_text): void
    {
        $this->message_text = $this->filterString($message_text);
    }
}
