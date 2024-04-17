<?php
require_once 'view.php';
require_once 'routeController.php';
require_once 'sessionController.php';
require_once 'errorController.php';
require_once 'user.php';

class App
{
    public function viewSignIn()
    {
        $v = new View();
        $v->buildPage('signIn');
        $v->show();
    }

    public function viewSignUp()
    {
        $v = new View();
        $v->buildPage('signUp');
        $v->show();
    }

    public function viewHomeWithoutLoggingIn()
    {
        $sc = new SessionController();
        if ($sc->getData('user') === null) {
            $v = new View();
            $v->buildPage('homeWithoutLoggingIn');
            $v->show();
        } else {
            $u = $sc->getData('user');
            $rc = new RouteController();
            if ($u->checkAccessKey('Administrator') === true) {
                $rc->redirect('view-homeAdministrator');
            } elseif ($u->checkAccessKey('Executive') === true) {
                $rc->redirect('view-homeExecutive');
            } elseif ($u->checkAccessKey('Operator') === true) {
                $rc->redirect('view-homeOperator');
            }
        }
    }

    public function viewNotificationPage()
    {
        $v = new View();
        $ec = new ErrorController();
        $v->buildPage('notificationPage');
        $ec->resetErrors();
        $v->show();
    }

    public function viewHomeOperator()
    {
        $v = new View();
        $v->buildPage('homeOperator');
        $v->show();
    }

    public function viewSinisterOperator()
    {
        $v = new View();
        $v->buildPage('sinisterOperator');
        $v->show();
    }

    public function viewTaskOperator()
    {
        $v = new View();
        $v->buildPage('taskOperator');
        $v->show();
    }

    public function viewSolutionOperator()
    {
        $v = new View();
        $v->buildPage('solutionOperator');
        $v->show();
    }

    public function userSignIn()
    {
        $ec = new ErrorController();
        $errors = false;

        if ($_POST['email'] === '') {
            $ec->addError('signInEmail', 'Debe ingresar su correo electrónico, no puede quedar vacío.');
            $errors = true;
        }

        if ($_POST['password'] === '') {
            $ec->addError('signInPassword', 'Debe ingresar su contraseña, no puede quedar vacío.');
            $errors = true;
        }

        $rc = new RouteController();
        $sc = new SessionController();
        $redirectPage = '';

        if ($errors === true) {
            $sc->addData('signInForm', $_POST);
            $redirectPage = 'error-signIn';
        } else {
            $u = new User($_POST['email'], $_POST['password']);
            if ($u->checkEmail() === true) {
                if ($u->checkPassword() === true) {
                    $u->load();
                    if (isset($_POST['rememberMe']) === true) {
                        if ($_POST['rememberMe'] === "on") {
                            $sc->createCookie('sinisterAppUserSession', $u->getId());
                        }
                    }
                    $sc->addData('user', $u);
                    if ($u->checkAccessKey('Administrator') === true) {
                        $redirectPage = 'view-homeAdministrator';
                    } elseif ($u->checkAccessKey('Executive') === true) {
                        $redirectPage = 'view-homeExecutive';
                    } elseif ($u->checkAccessKey('Operator') === true) {
                        $redirectPage = 'view-homeOperator';
                    } else {
                        $ec->addError('signInAccessKey', 'Debes aguardar a que los administradores te otorguen tu llave de acceso.');
                        $redirectPage = 'view-notificationPage';
                    }
                } else {
                    $ec->addError('signInPassword', 'Error, la contraseña es incorrecta.');
                    $redirectPage = 'error-signIn';
                }
            } else {
                $ec->addError('signInEmail', 'Error, el correo electrónico no se encuentra registrado. Debe registrarse primero.');
                $redirectPage = 'error-signIn';
            }
        }
        $rc->redirect($redirectPage);
    }

    public function userSignUp()
    {
        $ec = new ErrorController();
        $rc = new RouteController();
        $errors = false;
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
            $rc->redirect('error-signUp');
        } else {
            $u = new User($_POST['email'], $_POST['password'], $_POST['name'], $_POST['birthdate']);
            if ($u->store() === true) {
                $ec->addError('notificationSuccessful', 'Su registro fue completado con éxito, los administradores le otorgarán una llave de acceso para que puedas iniciar sesión.');
            } else {
                $ec->addError('notificationFailed', 'Su registro no pudo ser completado, contactese con los administradores para obtener más información al respecto.');
            }
            $rc->redirect('view-notificationPage');
        }
    }

    public function errorUnknownRoute()
    {
        $v = new View();
        $v->buildPage('errorUnknownRoute');
        $v->show();
    }

    public function errorSignUp()
    {
        $sc = new SessionController();
        $_POST = $sc->getData('signUpForm');
        $sc->removeData('signUpForm');
        $v = new View();
        $v->buildPage('signUp');
        $ec = new ErrorController();
        $ec->resetErrors();
        $v->show();
    }

    public function errorSignIn()
    {
        $sc = new SessionController();
        $_POST = $sc->getData('signInForm');
        $sc->removeData('signInForm');
        $v = new View();
        $v->buildPage('signIn');
        $ec = new ErrorController();
        $ec->resetErrors();
        $v->show();
    }
}
