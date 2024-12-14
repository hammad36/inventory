<?php

namespace inventory\models;

use inventory\lib\inputFilter;

class usersModel extends abstractModel
{
    use inputFilter;

    // Class Properties
    protected $user_id;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $date_of_birth;
    protected $gender;
    protected $role;
    protected $created_at;
    protected $updated_at;

    // Table Metadata
    protected static $tableName = 'users';
    protected static $tableSchema = [
        'first_name'      => self::DATA_TYPE_STR,
        'last_name'       => self::DATA_TYPE_STR,
        'email'           => self::DATA_TYPE_STR,
        'password'        => self::DATA_TYPE_STR,
        'date_of_birth'   => self::DATA_TYPE_DATE,
        'gender'          => self::DATA_TYPE_STR,
        'role'            => self::DATA_TYPE_STR,
        'created_at'      => self::DATA_TYPE_DATE,
        'updated_at'      => self::DATA_TYPE_DATE,
    ];

    protected static $primaryKey = 'user_id';

    // Setters
    public function setFirstName($firstName)
    {
        $this->first_name = $this->filterString($firstName, 2, 50);
    }

    public function setLastName($lastName)
    {
        $this->last_name = $this->filterString($lastName, 2, 50);
    }

    public function setDateOfBirth($dateOfBirth)
    {
        $this->date_of_birth = $this->filterDate($dateOfBirth);
    }

    public function setGender($gender)
    {
        $validGenders = ['male', 'female'];
        if (!in_array($gender, $validGenders)) {
            throw new \Exception("Invalid gender. Allowed values: 'male', 'female'.");
        }
        $this->gender = $gender;
    }

    public function setEmail($email)
    {
        $filteredEmail = $this->filterEmail($email);
        if (!$filteredEmail) {
            throw new \Exception('Invalid email format.');
        }
        $this->email = $filteredEmail;
    }

    public function setPassword($password)
    {
        if (strlen($password) < 6) {
            throw new \Exception('Password must be at least 6 characters.');
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setRole($role)
    {
        $validRoles = ['admin', 'user'];
        if (!in_array($role, $validRoles)) {
            throw new \Exception("Invalid role. Allowed values: 'admin', 'user'.");
        }
        $this->role = $role;
    }



    public function setCreatedAt($createdAt)
    {
        $this->created_at = $this->filterDate($createdAt);
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $this->filterDate($updatedAt);
    }

    // Getters
    public function getUserID()
    {
        return $this->user_id;
    }
    public function getFirstName()
    {
        return $this->first_name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRole()
    {
        return $this->role;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    // Additional Methods
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE email = :email';
        $params = ['email' => [self::DATA_TYPE_STR, $email]];
        $result = self::get($sql, $params);
        return !empty($result) ? $result[0] : null;
    }
}
