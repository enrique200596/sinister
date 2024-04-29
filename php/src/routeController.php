<?php

use function PHPSTORM_META\type;

require_once 'app.php';

class RouteController
{
    private $routes;

    public function __construct()
    {
        //********************VIEWS********************
        $this->addRoute('view', 'signIn', function () {
            $app = new App();
            $app->viewSignIn();
        });

        $this->addRoute('view', 'signUp', function () {
            $app = new App();
            $app->viewSignUp();
        });

        $this->addRoute('view', 'notificationPage', function () {
            $app = new App();
            $app->viewNotificationPage();
        });

        $this->addRoute('view', 'homeWithoutLoggingIn', function () {
            $app = new App();
            $app->viewHomeWithoutLoggingIn();
        });

        $this->addRoute('view', 'homeAdministrator', function () {
            $app = new App();
            $app->viewHomeAdministrator();
        });

        $this->addRoute('view', 'homeExecutive', function () {
            $app = new App();
            $app->viewHomeExecutive();
        });

        $this->addRoute('view', 'homeOperator', function () {
            $app = new App();
            $app->viewHomeOperator();
        });

        $this->addRoute('view', 'sinisterAdministrator', function () {
            $app = new App();
            $app->viewSinisterAdministrator();
        });

        $this->addRoute('view', 'sinisterExecutive', function () {
            $app = new App();
            $app->viewSinisterExecutive();
        });

        $this->addRoute('view', 'sinisterOperator', function () {
            $app = new App();
            $app->viewSinisterOperator();
        });

        $this->addRoute('view', 'taskAdministrator', function () {
            $app = new App();
            $app->viewTaskAdministrator();
        });

        $this->addRoute('view', 'taskExecutive', function () {
            $app = new App();
            $app->viewTaskExecutive();
        });

        $this->addRoute('view', 'taskOperator', function () {
            $app = new App();
            $app->viewTaskOperator();
        });

        $this->addRoute('view', 'solutionAdministrator', function () {
            $app = new App();
            $app->viewSolutionAdministrator();
        });

        $this->addRoute('view', 'solutionExecutive', function () {
            $app = new App();
            $app->viewSolutionExecutive();
        });

        $this->addRoute('view', 'solutionOperator', function () {
            $app = new App();
            $app->viewSolutionOperator();
        });

        //********************USERS********************
        $this->addRoute('user', 'signIn', function () {
            $app = new App();
            $app->userSignIn();
        });

        $this->addRoute('user', 'signUp', function () {
            $app = new App();
            $app->userSignUp();
        });

        //********************ERRORS********************
        $this->addRoute('error', 'unknownRoute', function () {
            $app = new App();
            $app->errorUnknownRoute();
        });

        $this->addRoute('error', 'signUp', function () {
            $app = new App();
            $app->errorSignUp();
        });

        $this->addRoute('error', 'signIn', function () {
            $app = new App();
            $app->errorSignIn();
        });
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

    public function validateRoute(Route|string $r)
    {
        if (!(gettype($r) === 'string')) {
            if ($r->getName() === '-') {
                $this->redirect('view-homeWithoutLoggingIn');
            }
            $r = $r->getName();
        } else {
            return isset($this->routes[$r]);
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
        $url = '';
        if ($this->validateRoute($routeName) === true) {
            $url = $this->getRoute($routeName)->getUrl();
        } else {
            $url = $this->getRoute('error-unknownRoute')->getUrl();
        }
        header('Location: ' . $url);
        die();
    }

    public function load(Route $r)
    {
        $r->setFunction($this->getRoute($r->getName())->getFunction());
        $r->setAccessKey($this->getRoute($r->getName())->getAccessKey());
        return $r;
    }
}
