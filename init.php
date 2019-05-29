<?php

// PHP
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// App
define('ROOT_PATH', __DIR__);
define('WEB_PATH', __DIR__ . '/web');

require_once ROOT_PATH . '/App/App.php';