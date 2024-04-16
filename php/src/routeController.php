<?php
require_once 'app.php';

class RouteController
{
    private $routes;

    public function __construct()
    {
        $this->addRoute('view', 'signIn', function () {
            $app = new App();
            $app->showSignInView();
        });

        $this->addRoute('view', 'signUp', function () {
            $app = new App();
            $app->showSignUpView();
        });

        $this->addRoute('view', 'homeWithoutLoggingIn', function () {
            $app = new App();
            $app->showHomeWithoutLogginInView();
        });

        $this->addRoute('view', 'notificationPage', function () {
            $app = new App();
            $app->showNotificationPageView();
        });

        $this->addRoute(
            'user',
            'signIn',
            function () {
                $app = new App();
                $app->signIn();
            }
        );

        $this->addRoute(
            'user',
            'signUp',
            function () {
                $errors = false;
                $ec = new ErrorController();
                if ($_POST['name'] === '') {
                    $ec->addError('signUpName', 'Debe ingresar su nombre, no puede quedar vacío.');
                    $errors = true;
                }
                if (strlen($_POST['birthdate']) === 0) {
                    $ec->addError('signUpBirthdate', 'Debe ingresar su fecha de nacimiento, no puede quedar vacío.');
                    $errors = true;
                }
                if ($_POST['email'] === '') {
                    $ec->addError('signUpEmail', 'Debe ingresar su correo electrónico, no puede quedar vacío.');
                    $errors = true;
                }
                if ($_POST['password'] === '') {
                    $ec->addError('signUpPassword', 'Debe ingresar una contraseña, no puede quedar vacío.');
                    $errors = true;
                }
                if ($_POST['passwordVerify'] === '') {
                    $ec->addError('signUpPasswordVerify', 'Debe ingresar la misma contraseña, no puede quedar vacío.');
                    $errors = true;
                }
                if (!($_POST['password'] === $_POST['passwordVerify'])) {
                    $ec->addError('signUpPasswordVerify', 'Las contraseñas no coinciden, compruebe que ambas sean iguales.');
                    $errors = true;
                }
                if ($errors === true) {
                    $sc = new SessionController();
                    $sc->addData('signUpForm', $_POST);
                    $this->redirect('error-signUp');
                } else {
                    $u = new User($_POST['email'], $_POST['password'], $_POST['name'], $_POST['birthdate']);
                    if ($u->store() === true) {
                        $ec->addError('notificationSuccessful', 'Su registro fue completado con éxito, los administradores le otorgarán una llave de acceso para que puedas iniciar sesión.');
                    } else {
                        $ec->addError('notificationFailed', 'Su registro no pudo ser completado, contactese con los administradores para obtener más información al respecto.');
                    }
                    $this->redirect('view-notificationPage');
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
