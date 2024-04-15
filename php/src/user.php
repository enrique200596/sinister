<?php
class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $accessKey;

    public function __construct(string $email, string $password)
    {
        $this->setEmail($email);
        $this->setPassword($password);
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

    public function checkEmail()
    {
        if (gettype($this->getEmail()) === 'string') {
            $connection = new mysqli('db', 'root', '123456', 'sinister');
            $result = $connection->query("'SELECT * FROM users WHERE email='" . $this->getEmail());
            $connection->close();
            if ($result !== null) {
                return true;
            } else {
                return null;
            }
        } else {
            return false;
        }
    }
}
