<?php
require_once 'view.php';
require_once 'routeController.php';
require_once 'sessionController.php';
require_once 'errorController.php';

class App
{
    public function showSignInView()
    {
        $v = new View();
        $v->buildPage('signIn');
        $v->show();
    }

    public function showSignUpView()
    {
        $v = new View();
        $v->buildPage('signUp');
        $v->show();
    }

    public function showHomeWithoutLogginInView()
    {
        $v = new View();
        $v->buildPage('homeWithoutLoggingIn');
        $v->show();
    }

    public function showNotificationPageView()
    {
        $v = new View();
        $ec = new ErrorController();
        $v->buildPage('notificationPage');
        $ec->resetErrors();
        $v->show();
    }

    public function signIn()
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
                    if ($_POST['rememberMe'] === "on") {
                        $sc->createCookie('sinisterAppUserSession', $u->getId());
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
}
