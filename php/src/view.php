<?php
require_once 'component.php';
require_once 'routeController.php';
require_once 'errorController.php';

class View
{
    private $components;
    private $page;

    public function __construct()
    {
        $this->components = [];

        $this->addComponent('doctype', new Component('!DOCTYPE', ['noKey' => 'html']));

        $this->addComponent(
            'html',
            new Component('html', ['lang' => 'es'], '', [
                'head' => new Component('head', [], '', [
                    'metaCharset' => new Component('meta', ['charset' => 'UTF-8']),
                    'metaNameContent' => new Component('meta', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']),
                    'title' => new Component('title')
                ]),
                'body' => new Component('body')
            ])
        );
    }

    private function setPage(string $page)
    {
        $this->page = $page;
    }

    private function getPage()
    {
        return $this->page;
    }

    private function addComponent(string $componentName, Component $c)
    {
        $this->components[$componentName] = $c;
    }

    private function getComponent(string $componentName)
    {
        if (isset($this->components[$componentName]) === true) {
            return $this->components[$componentName];
        } else {
            return '';
        }
    }

    public function buildPage(string $pageName)
    {
        switch ($pageName) {
            case 'homeWithoutLoggingIn':
                $this->getComponent('html')->getSubComponents('head')->getSubComponents('title')->setValue('Iniciar sesión - SinisterApp');
                $rc = new RouteController();
                $this->getComponent('html')->getSubComponents('body')->setSubComponents([
                    'header' => new Component('header', [], '', [
                        'h1' => new Component('h1', [], 'INICIO'),
                        'h2' => new Component('h2', [], 'SinisterApp')
                    ]),
                    'main' => new Component('main', [], '', [
                        'p' => new Component('p', [], 'Bienvenido a SinisterApp, una aplicación para gestionar los siniestros de vehículos de manera eficiente.<br>Debes registrarte e iniciar sesión para poder utilizar las herramientas de la aplicación.'),
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => $rc->getRoute('view-signIn')->getUrl()], 'INICIAR SESION'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => $rc->getRoute('view-signUp')->getUrl()], 'REGISTRARSE'),
                            ])
                        ])
                    ]),
                    'footer' => new Component('footer', [], '', [
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], '¿Quiénes somos?'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], 'Contáctanos'),
                            ])
                        ]),
                        'span' => new Component('span', [], 'ILLESOFT © Derechos reservados')
                    ])
                ]);
                break;
            case 'homeOperator':
                $this->getComponent('html')->getSubComponents('head')->getSubComponents('title')->setValue('Iniciar sesión - SinisterApp');
                $rc = new RouteController();
                $this->getComponent('html')->getSubComponents('body')->setSubComponents([
                    'header' => new Component('header', [], '', [
                        'h1' => new Component('h1', [], 'INICIO - OPERADORES'),
                        'h2' => new Component('h2', [], 'SinisterApp')
                    ]),
                    'main' => new Component('main', [], '', [
                        'p' => new Component('p', [], 'Bienvenido a SinisterApp, una aplicación para gestionar los siniestros de vehículos de manera eficiente.<br>Te encuentras en la sección de inicio - operadores, revisa la barra de navegación para poder utilizar la aplicación.'),
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => $rc->getRoute('view-sinisterOperator')->getUrl()], 'SINIESTROS'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => $rc->getRoute('view-taskOperator')->getUrl()], 'TAREAS'),
                            ]),
                            'li3' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => $rc->getRoute('view-solutionOperator')->getUrl()], 'SOLUCIONES')
                            ])
                        ])
                    ]),
                    'footer' => new Component('footer', [], '', [
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], '¿Quiénes somos?'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], 'Contáctanos'),
                            ])
                        ]),
                        'span' => new Component('span', [], 'ILLESOFT © Derechos reservados')
                    ])
                ]);
                break;

            case 'notificationPage':
                $this->getComponent('html')->getSubComponents('head')->getSubComponents('title')->setValue('Iniciar sesión - SinisterApp');
                $rc = new RouteController();
                $ec = new ErrorController();
                $this->getComponent('html')->getSubComponents('body')->setSubComponents([
                    'header' => new Component('header', [], '', [
                        'h1' => new Component('h1', [], 'NOTIFICACIONES'),
                        'h2' => new Component('h2', [], 'SinisterApp')
                    ]),
                    'main' => new Component('main', [], '', [
                        'p' => new Component('p', [], 'Su proceso generó las siguientes notificaciones:'),
                        'ul' => new Component('ul', [], '', $ec->getErrorsComponents('li'))
                    ]),
                    'footer' => new Component('footer', [], '', [
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], '¿Quiénes somos?'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], 'Contáctanos'),
                            ])
                        ]),
                        'span' => new Component('span', [], 'ILLESOFT © Derechos reservados')
                    ])
                ]);
                break;

            case 'signIn':
                $this->getComponent('html')->getSubComponents('head')->getSubComponents('title')->setValue('Iniciar sesión - SinisterApp');
                $rc = new RouteController();
                $ec = new ErrorController();
                $this->getComponent('html')->getSubComponents('body')->setSubComponents([
                    'header' => new Component('header', [], '', [
                        'h1' => new Component('h1', [], 'INICIAR SESION'),
                        'h2' => new Component('h2', [], 'SinisterApp')
                    ]),
                    'main' => new Component('main', [], '', [
                        'p' => new Component('p', [], 'Ingresa tus datos en el siguiente formulario.'),
                        'form' => new Component('form', ['action' => $rc->getRoute('user-signIn')->getUrl(), 'method' => 'POST'], '', [
                            'sectionEmail' => new Component('section', ['id' => 'sectionEmail'], '', [
                                'label' => new Component('label', ['for' => 'email'], 'Correo electrónico'),
                                'input' => new Component('input', ['type' => 'email', 'name' => 'email', 'id' => 'email', 'value' => (isset($_POST['email']) === true) ? $_POST['email'] : '']),
                                'span' => new Component('span', ['id' => 'spanEmail'], $ec->getError('signInEmail'))
                            ]),
                            'sectionPassword' => new Component('section', ['id' => 'sectionPassword'], '', [
                                'label' => new Component('label', ['for' => 'password'], 'Contraseña'),
                                'input' => new Component('input', ['type' => 'password', 'name' => 'password', 'id' => 'password']),
                                'span' => new Component('span', ['id' => 'spanPassword'], $ec->getError('signInPassword'))
                            ]),
                            'sectionRememberMe' => new Component('section', ['id' => 'sectionRememberMe'], '', [
                                'input' => new Component('input', ['type' => 'checkbox', 'name' => 'rememberMe', 'id' => 'rememberMe', 'value' => (isset($_POST['rememberMe']) === true) ? $_POST['rememberMe'] : '']),
                                'label' => new Component('label', ['for' => 'rememberMe'], 'Recordar mi sesión en este equipo.')
                            ]),
                            'input' => new Component('input', ['type' => 'submit', 'value' => 'INICIAR SESION'], ''),
                            'p' => new Component('p', [], 'Si no tienes credenciales para iniciar sesión debes registrarte:'),
                            'a' => new Component('a', ['href' => $rc->getRoute('view-signUp')->getUrl()], 'REGISTRARSE')
                        ])
                    ]),
                    'footer' => new Component('footer', [], '', [
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], '¿Quiénes somos?'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], 'Contáctanos'),
                            ])
                        ]),
                        'span' => new Component('span', [], 'ILLESOFT © Derechos reservados')
                    ])
                ]);
                break;

            case 'signUp':
                $this->getComponent('html')->getSubComponents('head')->getSubComponents('title')->setValue('Iniciar sesión - SinisterApp');
                $rc = new RouteController();
                $ec = new ErrorController();
                $this->getComponent('html')->getSubComponents('body')->setSubComponents([
                    'header' => new Component('header', [], '', [
                        'h1' => new Component('h1', [], 'REGISTRARSE'),
                        'h2' => new Component('h2', [], 'SinisterApp')
                    ]),
                    'main' => new Component('main', [], '', [
                        'p' => new Component('p', [], 'Ingresa tus datos en el siguiente formulario.'),
                        'form' => new Component('form', ['action' => $rc->getRoute('user-signUp')->getUrl(), 'method' => 'POST'], '', [
                            'sectionName' => new Component('section', ['id' => 'sectionName'], '', [
                                'label' => new Component('label', ['for' => 'name'], 'Nombre'),
                                'input' => new Component('input', ['type' => 'text', 'name' => 'name', 'id' => 'name', 'value' => (isset($_POST['name']) === true) ? $_POST['name'] : '']),
                                'span' => new Component('span', ['id' => 'spanName'], $ec->getError('signUpName'))
                            ]),
                            'sectionBirthdate' => new Component('section', ['id' => 'sectionBirthdate'], '', [
                                'label' => new Component('label', ['for' => 'birthdate'], 'Fecha de nacimiento'),
                                'input' => new Component('input', ['type' => 'date', 'name' => 'birthdate', 'id' => 'birthdate', 'value' => (isset($_POST['birthdate']) === true) ? $_POST['birthdate'] : '']),
                                'span' => new Component('span', ['id' => 'spanBirthdate'], $ec->getError('signUpBirthdate'))
                            ]),
                            'sectionEmail' => new Component('section', ['id' => 'sectionEmail'], '', [
                                'label' => new Component('label', ['for' => 'email'], 'Correo electrónico'),
                                'input' => new Component('input', ['type' => 'email', 'name' => 'email', 'id' => 'email', 'value' => (isset($_POST['email']) === true) ? $_POST['email'] : '']),
                                'span' => new Component('span', ['id' => 'spanEmail'], $ec->getError('signUpEmail'))
                            ]),
                            'sectionPassword' => new Component('section', ['id' => 'sectionPassword'], '', [
                                'label' => new Component('label', ['for' => 'password'], 'Contraseña'),
                                'input' => new Component('input', ['type' => 'password', 'name' => 'password', 'id' => 'password']),
                                'span' => new Component('span', ['id' => 'spanPassword'], $ec->getError('signUpPassword'))
                            ]),
                            'sectionPasswordVerify' => new Component('section', ['id' => 'sectionPasswordVerify'], '', [
                                'label' => new Component('label', ['for' => 'passwordVerify'], 'Verificar contraseña'),
                                'input' => new Component('input', ['type' => 'password', 'name' => 'passwordVerify', 'id' => 'passwordVerify']),
                                'span' => new Component('span', ['id' => 'spanPasswordVerify'], $ec->getError('signUpPasswordVerify'))
                            ]),
                            'input' => new Component('input', ['type' => 'submit', 'value' => 'REGISTRARSE'], ''),
                            'p' => new Component('p', [], 'Si ya tienes un usuario debes iniciar sesión:'),
                            'a' => new Component('a', ['href' => $rc->getRoute('view-signIn')->getUrl()], 'INICIAR SESION')
                        ])
                    ]),
                    'footer' => new Component('footer', [], '', [
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], '¿Quiénes somos?'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], 'Contáctanos'),
                            ])
                        ]),
                        'span' => new Component('span', [], 'ILLESOFT © Derechos reservados')
                    ])
                ]);
                break;

            default:
                $this->getComponent('html')->getSubComponents('head')->getSubComponents('title')->setValue('Error - SinisterApp');
                $rc = new RouteController();
                $this->getComponent('html')->getSubComponents('body')->setSubComponents([
                    'header' => new Component('header', [], '', [
                        'h1' => new Component('h1', [], 'PAGINA 404'),
                        'h2' => new Component('h2', [], 'SinisterApp')
                    ]),
                    'main' => new Component('main', [], '', [
                        'p' => new Component('p', [], 'La vista de la página a la que intenta acceder no pudo ser encontrada.'),
                        'a' => new Component('a', ['href' => $rc->getRoute('view-homeWithoutLoggingIn')->getUrl()], 'IR A LA PAGINA PRINCIPAL')
                    ]),
                    'footer' => new Component('footer', [], '', [
                        'ul' => new Component('ul', [], '', [
                            'li1' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], '¿Quiénes somos?'),
                            ]),
                            'li2' => new Component('li', [], '', [
                                'a' => new Component('a', ['href' => '#'], 'Contáctanos'),
                            ])
                        ]),
                        'span' => new Component('span', [], 'ILLESOFT © Derechos reservados')
                    ])
                ]);
                break;
        }
        $this->getComponent('doctype')->build();
        $this->getComponent('html')->build();
        $this->setPage($this->getComponent('doctype')->getHtml() . $this->getComponent('html')->getHtml());
    }

    public function show()
    {
        echo $this->getPage();
    }
}
