<?php
require_once 'route.php';
$route = new Route();
$route->addAccessKey('Administrator');
var_dump($route->checkAccessKey('Administrator'));