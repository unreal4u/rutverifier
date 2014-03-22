<?php

include('../vendor/autoload.php');

$rutVerifier = new unreal4u\rutverifier();

var_dump($rutVerifier->isValidRUT('30.686.957-4'));
var_dump($rutVerifier->isValidRUT('30686957-4'));
var_dump($rutVerifier->isValidRUT('306869574'));

var_dump($rutVerifier->isValidRUT('30.686.957-0'));

var_dump($rutVerifier->formatRUT('30.686.957-0', false));

echo $rutVerifier.'<br />'.PHP_EOL;

// Include javascript validation with the following function:
echo $rutVerifier->constructJavascript();
