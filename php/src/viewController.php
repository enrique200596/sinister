<?php
require_once 'view.php';

class ViewController
{
    private View $v;
    public function __construct()
    {
        $this->v = new View();
    }
    public function build(string $viewName)
    {
        if ($viewName === 'guestHome') {
            $this->v->setTitle('Inicio - SinisterApp');
            $this->v->setHeaderTitle('PAGINA DE INICIO');
            $this->v->setHeaderSubTitle('SinisterApp');
        } elseif ($viewName === 'operatorHome') {
            $this->v->setTitle('Inicio Operador - SinisterApp');
            $this->v->setHeaderTitle('PAGINA DE INICIO - OPERADOR');
            $this->v->setHeaderSubTitle('SinisterApp');
        } elseif ($viewName === 'executiveHome') {
            $this->v->setTitle('Inicio Ejecutivo - SinisterApp');
            $this->v->setHeaderTitle('PAGINA DE INICIO - EJECUTIVO');
            $this->v->setHeaderSubTitle('SinisterApp');
        } elseif ($viewName === 'administratorHome') {
            $this->v->setTitle('Inicio Administrador - SinisterApp');
            $this->v->setHeaderTitle('PAGINA DE INICIO - ADMINISTRADOR');
            $this->v->setHeaderSubTitle('SinisterApp');
        }
        $this->v->build();
    }
    public function show()
    {
        $this->v->show();
    }
}
