<?php

require __DIR__ . '/bootstrap.php';

$app = new Silex\Application();

$app['debug'] = true;

require __DIR__ . '/../config/application.config.php';

$app->run();

