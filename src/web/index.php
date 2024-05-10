<?php
date_default_timezone_set('America/Sao_Paulo');

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$yii = dirname(__FILE__) . '/yii/yiilite.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

$ambientesDeDesenvolvimento = ['localhost:8000', 'localhost:8080', 'localhost', 'tarsius.dev'];
defined('YII_DEBUG') or define('YII_DEBUG', in_array($_SERVER['HTTP_HOST'], $ambientesDeDesenvolvimento));
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once(__DIR__ . '/../tarsius/vendor/autoload.php');
require_once($yii);
Yii::createWebApplication($config)->run();
