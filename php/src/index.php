<?php
require_once 'component.php';
$formulario = new Component('form', ['method' => 'POST', 'action' => '#']);
$sectionEmail = new Component('section', ['id' => 'sectionEmail']);
$labelEmail = new Component('label', ['id' => 'labelEmail', 'for' => 'inputEmail']);
$inputEmail = new Component('input', ['id' => 'inputEmail', 'type' => 'email', 'name' => 'email']);
$spanEmail = new Component('span', ['id' => 'spanEmail']);
$sectionEmail->addSubComponent($labelEmail->getAttribute('id'), $labelEmail);
$sectionEmail->addSubComponent($inputEmail->getAttribute('id'), $inputEmail);
$sectionEmail->addSubComponent($spanEmail->getAttribute('id'), $spanEmail);
