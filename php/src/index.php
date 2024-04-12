<?php
require_once 'route.php';
require_once 'routeController.php';

$r = new Route();
$r->identifyObject();
$r->identifyProcess();
$rc = new RouteController();
if ($rc->validateRoute($r) === false) {
    $rc->redirect('error-unknownRoute');
} else {
    $r = $rc->load($r);
}
$r->getFunction()();
