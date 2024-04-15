<?php
require_once "sessionController.php";
class ErrorController
{
    private $errors;

    public function __construct()
    {
        $this->updateErrors();
    }

    private function checkError($errorName)
    {
        return isset($this->errors[$errorName]);
    }

    public function getError(string $errorName)
    {
        if ($this->checkError($errorName) === true) {
            return $this->errors[$errorName];
        } else {
            return '';
        }
    }

    public function updateErrors()
    {
        $sc = new SessionController();
        $this->errors = $sc->getData('errors');
    }
}
