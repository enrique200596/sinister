<?php
require_once 'route.php';
require_once 'routeController.php';
require_once 'viewController.php';
require_once 'userSession.php';

class App
{
    private Route $route;
    private RouteController $rc;

    public function __construct()
    {
        $this->route = new Route();
        $this->rc = new RouteController();
        $this->initializeRoutes();
    }

    public function run()
    {
        $this->route->identifyObject();
        $this->route->identifyProcess();

        if ($this->route->getName() === '-') {
            $this->route->setObject('view');
            $this->route->setProcess('home');
            $this->redirect($this->route->getUrl());
        }

        if ($this->rc->checkRoute($this->route->getName()) === true) {
            $this->route = $this->rc->getRoute($this->route->getName());
        }

        $this->execute();
    }

    private function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    private function initializeRoutes()
    {
        $this->rc->addRoute(new Route('view', 'home', ['administrator', 'executive', 'operator', 'guest']));
        $this->rc->addRoute(new Route('view', 'signIn', ['guest']));
        $this->rc->addRoute(new Route('view', 'signUp', ['guest']));
    }

    private function execute()
    {

        switch ($this->route->getName()) {
            case 'view-home':
                $this->showHomeView($this->verifyAccessControl());
                die();

            default:
                $this->showErrorRequestView();
                break;
        }
    }

    private function showHomeView(string $accessKey)
    {
        $vc = new ViewController();
        $vc->build($accessKey . 'Home');
        $vc->show();
    }

    private function verifyAccessControl()
    {
        $result = 'guest';

        $us = new UserSession();

        foreach ($this->route->getAccessKey() as $value) {
            var_dump(password_verify($value, $us->getUser()->getAccessKey()));
            if (password_verify($value, $us->getUser()->getAccessKey()) === true) {
                $result = $value;
                break;
            }
        }
        return $result;
    }

    private function showErrorRequestView()
    {
        $vc = new ViewController();
        $nc = new NotificationController();
        $vc->build('notificationError');
    }
}
