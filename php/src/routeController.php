<?php
require_once 'view.php';

class RouteController
{
    private $routes;
    public function __construct()
    {
        $this->addRoute(
            'view',
            'signIn',
            function () {
                $v = new View();
                $v->buildPage('signIn');
                $v->show();
            }
        );

        $this->addRoute(
            'view',
            'signUp',
            function () {
                $v = new View();
                $v->buildPage('signUp');
                $v->show();
            }
        );

        $this->addRoute(
            'view',
            'homeWithoutLoggingIn',
            function () {
                $v = new View();
                $v->buildPage('homeWithoutLoggingIn');
                $v->show();
            }
        );

        $this->addRoute(
            'user',
            'signIn',
            function () {
                var_dump($_POST);
            }
        );

        $this->addRoute(
            'user',
            'signUp',
            function () {
                if (!($_POST['password'] === $_POST['passwordVerify'])) {
                    $this->redirect('error-signUpPasswordVerify');
                }
            }
        );

        $this->addRoute(
            'error',
            'unknownRoute',
            function () {
                $v = new View();
                $v->buildPage('errorUnknownRoute');
                $v->show();
            }
        );

        $this->addRoute(
            'error',
            'signUpPasswordVerify',
            function () {
                $v = new View();
                $v->buildPage('signUp');
                $v->show();
            }
        );
    }

    private function addRoute(string $object, string $process, Closure $function, string $accessKey = '')
    {
        $r = new Route(
            $object,
            $process,
            $function,
            $accessKey
        );

        $this->routes[$r->getName()] = $r;
    }

    public function validateRoute(Route $r)
    {
        if ($r->getName() === '-') {
            $this->redirect('view-homeWithoutLoggingIn');
        } else {
            return isset($this->routes[$r->getName()]);
        }
    }

    public function getRoute(string $routeName = '*')
    {
        if ($routeName === '*') {
            return $this->routes;
        } else {
            if (isset($this->routes[$routeName]) === true) {
                return $this->routes[$routeName];
            } else {
                return null;
            }
        }
    }

    public function redirect(string $routeName)
    {
        header('Location: ' . $this->getRoute($routeName)->getUrl());
        die();
    }

    public function load(Route $r)
    {
        $r->setFunction($this->getRoute($r->getName())->getFunction());
        $r->setAccessKey($this->getRoute($r->getName())->getAccessKey());
        return $r;
    }
}
