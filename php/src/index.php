<?php
require_once 'component.php';
$formulario = new Component('form', ['method' => 'POST', 'action' => '#']);
$sectionEmail = new Component('section', ['id' => 'sectionEmail']);
$labelEmail = new Component('label', ['id' => 'labelEmail', 'for' => 'inputEmail'],'Correo electrónico');
$inputEmail = new Component('input', ['id' => 'inputEmail', 'type' => 'email', 'name' => 'email']);
$spanEmail = new Component('span', ['id' => 'spanEmail'], 'Error: correo no registrado.');
$sectionEmail->addSubComponent($labelEmail->getAttribute('id'), $labelEmail);
$sectionEmail->addSubComponent($inputEmail->getAttribute('id'), $inputEmail);
$sectionEmail->addSubComponent($spanEmail->getAttribute('id'), $spanEmail);
$formulario->addSubComponent($sectionEmail->getAttribute('id'), $sectionEmail);
$formulario->build();
echo $formulario->getHtml();