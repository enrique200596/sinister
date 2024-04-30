<?php
require_once 'app.php';
$app = new App();
session_start();
$_SESSION['sinisterApp']['user'] = new User('', '', password_hash('operator', PASSWORD_DEFAULT));
$app->run();
