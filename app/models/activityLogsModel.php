<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class activityLogsModel extends abstractModel
{
    use inputFilter;

    protected $log_id;
    protected $user_id;
    protected $action;
    protected $timestamp;

    protected static $tableName = 'activity_logs';
    protected static $tableSchema = [
        'user_id'   => self::DATA_TYPE_INT,
        'action'    => self::DATA_TYPE_STR,
        'timestamp' => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'log_id';

    public function setUserId(int $user_id): void
    {
        $this->user_id = $this->filterInt($user_id);
    }

    public function setAction(string $action): void
    {
        $this->action = $this->filterString($action, 3, 255);
    }

    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $this->filterDate($timestamp);
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }
}
