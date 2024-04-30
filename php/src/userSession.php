<?php
require_once 'user.php';
require_once 'sessionController.php';

class UserSession
{
    private User $u;
    private SessionController $sc;

    public function __construct()
    {
        $this->u = new User('', '');
        $this->sc = new SessionController();
        $this->loadUserSession();
    }

    public function getUser()
    {
        return $this->u;
    }

    private function loadUserSession()
    {
        if ($this->sc->checkData('user') === true) {
            $this->u = $this->sc->getData('user');
        }
    }
}
