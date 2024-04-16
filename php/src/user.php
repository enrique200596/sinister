<?php
class User
{
    private $id;
    private $name;
    private $birthdate;
    private $email;
    private $password;
    private $accessKey;

    public function __construct(string $email, string $password, string $name = '', string $birthdate = '')
    {
        $this->setEmail($email);
        $this->setPassword($password);
        if ($name !== '') {
            $this->setName($name);
        }
        if ($birthdate !== '') {
            $this->setBirthdate($birthdate);
        }
    }

    private function setEmail(string $email)
    {
        $this->email = $email;
    }

    private function getEmail()
    {
        return $this->email;
    }

    private function setPassword(string $password)
    {
        $this->password = $password;
    }

    private function getPassword()
    {
        return $this->password;
    }

    private function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    private function setName($name)
    {
        $this->name = $name;
    }

    private function getName()
    {
        return $this->name;
    }

    private function setBirthdate(string $birthdate)
    {
        $this->birthdate = new Datetime($birthdate . "00:00:00");
    }

    private function getBirthdate(string $type)
    {
        if ($type === 'string') {
            return $this->birthdate->format('Y-m-d');
        } elseif ($type === 'datetime') {
            return $this->birthdate;
        } else {
            return null;
        }
    }

    private function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
    }

    private function getAccessKey()
    {
        return password_hash($this->accessKey, PASSWORD_DEFAULT);
    }

    public function checkEmail()
    {
        if ($this->getEmail() !== '') {
            $connection = new mysqli('db', 'root', '123456', 'sinister');
            $result = $connection->query("SELECT * FROM users WHERE email='" . $this->getEmail() . "'");
            $connection->close();
            if ($result->num_rows === 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    public function checkPassword()
    {
        if ($this->getPassword() !== '') {
            $connection = new mysqli('db', 'root', '123456', 'sinister');
            $result = $connection->query("SELECT password FROM users WHERE email='" . $this->getEmail() . "'");
            $connection->close();
            $result = $result->fetch_array(MYSQLI_ASSOC);
            return password_verify($this->getPassword(), $result['password']);
        } else {
            return null;
        }
    }

    public function load()
    {
        if ($this->checkEmail() === true && $this->checkPassword() === true) {
            $connection = new mysqli('db', 'root', '123456', 'sinister');
            $result = $connection->query("SELECT * FROM users WHERE email='" . $this->getEmail() . "'");
            $connection->close();
            $result = $result->fetch_array(MYSQLI_ASSOC);
            $this->setId($result["id"]);
            $this->setName($result["name"]);
            $this->setAccessKey($result["accessKey"]);
            return true;
        } else {
            return false;
        }
    }

    public function store()
    {
        if ($this->getEmail() !== '' && $this->getPassword() !== '' && $this->getName() !== '' && $this->getBirthdate('string') !== '') {
            $this->setPassword(password_hash($this->getPassword(), PASSWORD_DEFAULT));
            $connection = new mysqli('db', 'root', '123456', 'sinister');
            $result = $connection->query("INSERT INTO users (email,password,name,birthdate) VALUES ('" . $this->getEmail() . "','" . $this->getPassword() . "','" . $this->getName() . "','" . $this->getBirthdate('string') . " 00:00:00')");
            $connection->close();
            if ($result === false) {
                return $result;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function checkAccessKey(string $accessKey)
    {
        return password_verify($accessKey, $this->getAccessKey());
    }
}
