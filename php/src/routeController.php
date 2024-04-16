<?php
require_once 'app.php';

class RouteController
{
    private $routes;

    public function __construct()
    {
        $this->addRoute('view', 'signIn', function () {
            $app = new App();
            $app->viewSignIn();
        });

        $this->addRoute('view', 'signUp', function () {
            $app = new App();
            $app->viewSignUp();
        });

        $this->addRoute('view', 'homeWithoutLoggingIn', function () {
            $app = new App();
            $app->viewHomeWithoutLoggingIn();
        });

        $this->addRoute('view', 'notificationPage', function () {
            $app = new App();
            $app->viewNotificationPage();
        });

        $this->addRoute('user', 'signIn', function () {
            $app = new App();
            $app->userSignIn();
        });

        $this->addRoute('user', 'signUp', function () {
            $app = new App();
            $app->userSignUp();
        });

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
            'signUp',
            function () {
                $sc = new SessionController();
                $_POST = $sc->getData('signUpForm');
                $sc->removeData('signUpForm');
                $v = new View();
                $v->buildPage('signUp');
                $ec = new ErrorController();
                $ec->resetErrors();
                $v->show();
            }
        );

        $this->addRoute(
            'error',
            'signIn',
            function () {
                $sc = new SessionController();
                $_POST = $sc->getData('signInForm');
                $sc->removeData('signInForm');
                $v = new View();
                $v->buildPage('signIn');
                $ec = new ErrorController();
                $ec->resetErrors();
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
