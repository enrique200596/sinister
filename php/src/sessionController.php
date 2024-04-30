<?php
class SessionController
{
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['sinisterApp']) === false) {
            $_SESSION['sinisterApp'] = [];
        }
    }

    public function addData(string $dataName, mixed $data)
    {
        $_SESSION['sinisterApp'][$dataName] = $data;
    }

    public function checkData(string $dataName)
    {
        return isset($_SESSION['sinisterApp'][$dataName]);
    }

    public function getData(string $dataName)
    {
        return $_SESSION['sinisterApp'][$dataName];
    }

    public function removeData(string $dataName)
    {
        unset($_SESSION['sinisterApp'][$dataName]);
    }
}
