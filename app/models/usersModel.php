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
    protected $date_of_birth;
    protected $gender;
    protected $email;
    protected $password;
    protected $role;
    protected $status;
    protected $created_at;
    protected $updated_at;
    protected $last_login;
    protected $google_id;
    private $facebookId;
    protected $auth_provider = 'local'; // Default to 'local'

    // Table Metadata
    protected static $tableName = 'users';
    protected static $tableSchema = [
        'first_name'      => self::DATA_TYPE_STR,
        'last_name'       => self::DATA_TYPE_STR,
        'date_of_birth'   => self::DATA_TYPE_DATE,
        'gender'          => self::DATA_TYPE_STR,
        'email'           => self::DATA_TYPE_STR,
        'password'        => self::DATA_TYPE_STR,
        'role'            => self::DATA_TYPE_STR,
        'status'          => self::DATA_TYPE_STR,
        'created_at'      => self::DATA_TYPE_DATE,
        'updated_at'      => self::DATA_TYPE_DATE,
        'last_login'      => self::DATA_TYPE_DATE,
        'google_id'      => self::DATA_TYPE_STR,
        'auth_provider'  => self::DATA_TYPE_STR
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



    public function setEmail($email)
    {
        $filteredEmail = $this->filterEmail($email);
        if (!$filteredEmail) {
            throw new \Exception('Invalid email format.');
        }
        $this->email = $filteredEmail;
    }

    public function setGender($gender)
    {
        $gender = ucfirst(strtolower($gender)); // Converts input to 'Male' or 'Female'
        $validGenders = ['Male', 'Female'];
        if (!in_array($gender, $validGenders)) {
            throw new \Exception("Invalid gender. Allowed values: 'Male', 'Female'.");
        }
        $this->gender = $gender;
    }


    public function setRole($role)
    {
        $validRoles = ['user', 'admin'];
        if (!in_array($role, $validRoles)) {
            throw new \Exception("Invalid Role. Allowed values: 'user', 'admin'.");
        }
        $this->role = $role;
    }

    public function setStatus($status)
    {
        $validStatuses = ['active', 'inactive', 'banned'];
        if (!in_array($status, $validStatuses)) {
            throw new \Exception("Invalid Status. Allowed values: 'active', 'inactive', 'banned'.");
        }
        $this->status = $status;
    }


    public function setPassword($password)
    {
        if (strlen($password) < 8) {
            throw new \Exception('Password must be at least 8 characters.');
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setCreatedAt($createdAt)
    {
        $this->created_at = $this->filterDate($createdAt);
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $this->filterDate($updatedAt);
    }


    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;
    }

    public function setAuthProvider($provider)
    {
        $validProviders = ['local', 'google', 'facebook'];
        if (!in_array($provider, $validProviders)) {
            throw new \Exception('Invalid authentication provider');
        }
        $this->auth_provider = $provider;
    }
    public function setFacebookId($facebookId): void

    {

        $this->facebookId = $facebookId;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function getLastLogin()
    {
        return $this->last_login;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function updateLastLogin()
    {
        $this->last_login = date('Y-m-d H:i:s');
        // You might want to add logic to save this to the database
    }

    // Additional Methods
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE email = :email';
        $params = ['email' => [self::DATA_TYPE_STR, $email]];
        $result = self::get($sql, $params);
        return !empty($result) ? $result[0] : null;
    }

    public static function findByGoogleId($googleId)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE google_id = :google_id';
        $params = ['google_id' => [self::DATA_TYPE_STR, $googleId]];
        $result = self::get($sql, $params);
        return !empty($result) ? $result[0] : null;
    }

    public function getAuthProvider(): string
    {
        return $this->auth_provider;
    }

    public function getFacebookId()

    {

        return $this->facebookId;
    }
    // Optionally, add a setter method

}
