<?php
require_once "sessionController.php";

class ErrorController
{
    private $errors;

    public function __construct()
    {
        $this->loadErrors();
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

    private function loadErrors()
    {
        $sc = new SessionController();
        $this->errors = $sc->getData('errors');
    }

    private function updateErrors()
    {
        $sc = new SessionController();
        $sc->addData('errors', $this->errors);
    }

    public function addError(string $errorName, string $message)
    {
        $this->errors[$errorName] = $message;
        $this->updateErrors();
    }

    public function removeError(string $errorName)
    {
        unset($this->errors[$errorName]);
        $this->updateErrors();
    }
}
