<?php
class SessionController
{
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    }

    private function checkData($dataName)
    {
        return isset($_SESSION['sinisterApp'][$dataName]);
    }

    public function getData(string $dataName)
    {
        if ($this->checkData($dataName)) {
            return $_SESSION['sinisterApp'][$dataName];
        } else {
            return null;
        }
    }

    public function addData(string $dataName, mixed $data)
    {
        $_SESSION['sinisterApp'][$dataName] = $data;
    }

    public function removeData(string $dataName)
    {
        if ($this->checkData($dataName)) {
            unset($_SESSION[$dataName]);
        }
    }

    public function createCookie(string $cookieName, mixed $value)
    {
        setcookie($cookieName, $value, (time() * 60) * 10);
    }
}
