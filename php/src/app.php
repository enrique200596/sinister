<?php
require_once 'view.php';
require_once 'routeController.php';
require_once 'sessionController.php';
require_once 'errorController.php';
require_once 'user.php';

class App
{

    //--------------------FUNCIONES AUXILIARES DE APP--------------------
    private function redirect(string $routeName)
    {
        $rc = new RouteController();
        $rc->redirect($routeName);
    }

    private function checkSession()
    {
        $sc = new SessionController();
        if ($sc->getData('user') === null) {
            return false;
        } else {
            return true;
        }
    }

    private function redirectHome()
    {
        $sc = new SessionController();
        $u = $sc->getData('user');
        if ($u->checkAccessKey('Administrator') === true) {
            $this->redirect('view-homeAdministrator');
        } elseif ($u->checkAccessKey('Executive') === true) {
            $this->redirect('view-homeExecutive');
        } elseif ($u->checkAccessKey('Operator') === true) {
            $this->redirect('view-homeOperator');
        }
    }

    public function view(string $process)
    {
        $v = new View();
        $v->buildPage($process);
        $v->show();
    }

    private function routeAccessControl(string $view)
    {
        if ($view === 'signIn' || $view === 'signUp' || $view === 'homeWithoutLoggingIn') {
            if ($this->checkSession() === false) {
                $this->view($view);
            } else {
                $this->redirectHome();
            }
        } else {
            if ($this->checkSession() === true) {
                $this->view($view);
            } else {
                $this->redirect('view-signIn');
            }
        }
    }

    //--------------------FUNCIONES DE ROUTE-CONTROLLER--------------------

    //--------------------FUNCIONES DE VIEW--------------------
    public function viewSignIn()
    {
        if ($this->checkSession() === false) {
            $this->view('signIn');
        } else {
            $this->redirectHome();
        }
    }

    public function viewSignUp()
    {
        if ($this->checkSession() === false) {
            $this->view('signUp');
        } else {
            $this->redirectHome();
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

    public function viewHomeWithoutLoggingIn()
    {
        $this->routeAccessControl('homeWithoutLoggingIn');
    }

    public function viewHomeAdministrator()
    {
        $this->routeAccessControl('homeAdministrator');
    }

    public function viewHomeExecutive()
    {
        $this->routeAccessControl('homeExecutive');
    }

    public function viewHomeOperator()
    {
        $this->routeAccessControl('homeOperator');
    }

    public function viewSinisterAdministrator()
    {
        $this->routeAccessControl('sinisterAdministrator');
    }

    public function viewSinisterExecutive()
    {
        $this->routeAccessControl('sinisterExecutive');
    }

    public function viewSinisterOperator()
    {
        $this->routeAccessControl('sinisterOperator');
    }

    public function viewTaskAdministrator()
    {
        $this->routeAccessControl('taskAdministrator');
    }

    public function viewTaskExecutive()
    {
        $this->routeAccessControl('taskExecutive');
    }

    public function viewTaskOperator()
    {
        $this->routeAccessControl('taskOperator');
    }

    public function viewSolutionAdministrator()
    {
        $this->routeAccessControl('solutionAdministrator');
    }

    public function viewSolutionExecutive()
    {
        $this->routeAccessControl('solutionExecutive');
    }

    public function viewSolutionOperator()
    {
        $this->routeAccessControl('solutionOperator');
    }

    //--------------------FUNCIONES DE USER--------------------
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

    //--------------------FUNCIONES DE ERROR--------------------
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
