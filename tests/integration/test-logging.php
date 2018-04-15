<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/src/app.php';

$app['logger']->warning('foo');
$app['logger']->error('bar');

