<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class usersModel extends abstractModel
{
    use inputFilter;

    protected $user_id;
    protected $username;
    protected $password;
    protected $email;
    protected $role;
    protected $created_at;

    protected static $tableName = 'users';
    protected static $tableSchema = [
        'username'          => self::DATA_TYPE_STR,
        'password'          => self::DATA_TYPE_STR,
        'email'             => self::DATA_TYPE_STR,
        'role'              => self::DATA_TYPE_STR,
        'created_at'        => self::DATA_TYPE_DATE
    ];

    protected static $primaryKey = 'user_id';

    public function setUsername($username)
    {
        $this->username = $this->filterString($username, 3, 50);
    }

    public function setPassword($password)
    {
        $this->password = password_hash($this->filterString($password), PASSWORD_DEFAULT);
    }

    public function setEmail($email)
    {
        $this->email = $this->filterEmail($email);
    }

    public function setRole($role)
    {
        $validRoles = ['admin', 'user', 'manager'];
        $this->role = in_array($role, $validRoles) ? $role : throw new \Exception("Invalid role.");
    }

    public function setCreatedAt($date)
    {
        $this->created_at = $this->filterDate($date);
    }
}
