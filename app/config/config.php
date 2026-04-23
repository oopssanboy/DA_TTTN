<?php

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$scriptName = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
define('URLROOT', $protocol . "://" . $host . $scriptName);


define('APPROOT', dirname(dirname(__FILE__)));