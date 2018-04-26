<?php

$app = new Silex\Application();

$dotenv = new Dotenv\Dotenv(__DIR__.'/..');
$dotenv->load();

require __DIR__ . '/../config/application.config.php';

return $app;

